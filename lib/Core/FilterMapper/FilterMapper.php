<?php

declare(strict_types=1);

namespace Netgen\IbexaSearchFilter\FilterMapper;


use Netgen\IbexaSearchFilter\Core\Values\FilterRequest;
use Netgen\IbexaSearchFilter\Core\Values\Query;

final class FilterMapper
{
    public function __construct(
        private readonly FacetResolver $facetResolver,
        private readonly SortResolver $sortResolver,
        private readonly CategoriesMapper $categoriesMapper,
        private readonly FacetsMapper $facetsMapper,
        private readonly PagerMapper $pagerMapper,
        private readonly SelectedCategoryMapper $selectedCategoryMapper,
        private readonly SelectedFacetsMapper $selectedFacetsMapper,
    ) {
    }

    public function mapFullQuery(FilterRequest $filterRequest): Query
    {
        return new Query(
            $filterRequest->page,
            $filterRequest->hitsPerPage,
            $filterRequest->searchTerm,
            $this->sortResolver->resolveIndexName($filterRequest),
            $this->facetResolver->resolveFilters($filterRequest),
            $this->facetResolver->resolveAggregations($filterRequest),
        );
    }


    /**
     * @param array<string, mixed> $data
     */
    public function mapFullResponse(FilterRequest $filterRequest, array $data): FilterResponse
    {
        return new FilterResponse([
            'query' => trim(urldecode((string) $filterRequest->request->query->get('query'))),
            'selectedCategory' => $this->selectedCategoryMapper->map($filterRequest, $data),
            'categories' => $this->categoriesMapper->map($filterRequest, $data),
            'selectedFacets' => $this->selectedFacetsMapper->map($filterRequest, $data),
            'facets' => $this->facetsMapper->map($filterRequest, $data),
            //'pager' => $this->mapPagerResponse($filterRequest, $data),
        ]);
    }

}
