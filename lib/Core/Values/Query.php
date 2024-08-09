<?php

declare(strict_types=1);

namespace Netgen\IbexaSearchFilter\Core\Values;

final class Query
{
    /**
     * @param string[] $filters
     */
    public function __construct(
        private readonly int $page,
        private readonly int $hitsPerPage,
        private readonly string $searchTerm,
        private readonly string $indexName,
        private readonly array $filters,
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getHitsPerPage(): int
    {
        return $this->hitsPerPage;
    }

    public function getIndexName(): string
    {
        return $this->indexName;
    }

    public function getSearchTerm(): string
    {
        return $this->searchTerm ?? '*';
    }

    /**
     * @return string[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return array<int, mixed>
     */
    public function getQueries(): array
    {
        $queries = [
            $this->getMainQuery(),
        ];

        foreach ($this->getFacets() as $facet => $distinct) {
            $queries[] = $this->getFacetQuery($facet, $distinct);
        }

        return $queries;
    }

    /**
     * @return array<string, mixed>
     */
    private function getMainQuery(): array
    {
        return [
            'indexName' => $this->getIndexName(),
            'query' => $this->getSearchTerm(),
            'filters' => $this->serializeFilters($this->getFilters()),
            'hitsPerPage' => $this->getHitsPerPage(),
            'page' => $this->getPage() - 1,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function getFacetQuery(string $facet, int $distinct): array
    {
        return [
            'indexName' => $this->getIndexName(),
            'query' => $this->getSearchTerm(),
            'filters' => $this->serializeFilters($this->getUnfacetedFilters($facet)),
            'facets' => [$facet],
            'distinct' => $distinct,
            'facetingAfterDistinct' => true,
            'sortFacetValuesBy' => 'count',
            'maxValuesPerFacet' => 100,
            'hitsPerPage' => 0,
            'page' => 0,
        ];
    }

    /**
     * @return string[]
     */
    private function getUnfacetedFilters(string $facet): array
    {
        $filters = $this->getFilters();
        $unfacetedFilters = [];

        foreach ($filters as $key => $filter) {
            if ($key !== $facet) {
                $unfacetedFilters[$key] = $filter;
            }
        }

        return $unfacetedFilters;
    }

    /**
     * @param string[] $filters
     */
    private function serializeFilters(array $filters): string
    {
        return implode(' AND ', $filters);
    }
}
