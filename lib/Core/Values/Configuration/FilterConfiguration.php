<?php

declare(strict_types=1);

namespace Netgen\IbexaSearchFilter\Core\Values\Configuration;

use OutOfBoundsException;

final class FilterConfiguration
{
    /**
     * @param array<string, \Forlagshuset\AlgoliaFilterBundle\Core\Values\FacetDefinition> $facetDefinitionMap
     * @param array<string, \Forlagshuset\AlgoliaFilterBundle\Core\Values\SortDefinition> $sortDefinitionMap
     */
    public function __construct(
        private readonly string $identifier,
        private readonly array $facetDefinitionMap,
        private readonly array $sortDefinitionMap,
        private readonly int $maxResultWindowSize,
        private readonly string $categoryParameterName,
        private readonly string $sortParameterName,
        private readonly string $relevanceSortType,
        private readonly ViewConfiguration $viewConfiguration,
        private readonly string $symfonyEnvironment,
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return \Forlagshuset\AlgoliaFilterBundle\Core\Values\FacetDefinition[]
     */
    public function getAllFacetDefinitions(): array
    {
        return array_values($this->facetDefinitionMap);
    }

    /**
     * @return \Forlagshuset\AlgoliaFilterBundle\Core\Values\FacetDefinition[]
     */
    public function getEnabledFacetDefinitions(): array
    {
        $definitions = [];

        foreach ($this->viewConfiguration->getEnabledFacets() as $identifier) {
            $definition = $this->getFacetDefinitionByIdentifier($identifier);

            if ($definition->debug && $this->symfonyEnvironment === 'prod') {
                continue;
            }

            $definitions[] = $definition;
        }

        return $definitions;
    }

    public function getFacetDefinitionByIdentifier(string $identifier): FacetDefinition
    {
        return $this->facetDefinitionMap[$identifier] ?? throw new OutOfBoundsException(
            sprintf(
                'Facet definition with identifier "%s" was not found',
                $identifier,
            ),
        );
    }

    public function getFacetDefinitionByContributorRole(string $role): FacetDefinition
    {
        foreach ($this->facetDefinitionMap as $facetDefinition) {
            if ($facetDefinition->isContributor && $facetDefinition->contributorRole === $role) {
                return $facetDefinition;
            }
        }

        throw new OutOfBoundsException(
            sprintf(
                'Facet definition for role "%s" was not found',
                $role,
            ),
        );
    }

    /**
     * @return \Forlagshuset\AlgoliaFilterBundle\Core\Values\SortDefinition[]
     */
    public function getAllSortDefinitions(): array
    {
        return array_values($this->sortDefinitionMap);
    }

    /**
     * @return \Forlagshuset\AlgoliaFilterBundle\Core\Values\SortDefinition[]
     */
    public function getEnabledSortDefinitions(): array
    {
        $definitions = [];

        foreach ($this->viewConfiguration->getEnabledSortTypes() as $identifier) {
            $definitions[] = $this->getSortDefinitionByIdentifier($identifier);
        }

        return $definitions;
    }

    public function getSortDefinitionByIdentifier(string $identifier): SortDefinition
    {
        return $this->sortDefinitionMap[$identifier] ?? throw new OutOfBoundsException(
            sprintf(
                'Sort definition with identifier name "%s" was not found',
                $identifier,
            ),
        );
    }

    public function hasSortType(string $identifier): bool
    {
        return isset($this->sortDefinitionMap[$identifier]);
    }

    public function getMaxResultWindowSize(): int
    {
        return $this->maxResultWindowSize;
    }

    public function getCategoryParameterName(): string
    {
        return $this->categoryParameterName;
    }

    public function getSortParameterName(): string
    {
        return $this->sortParameterName;
    }

    public function getRelevanceSortType(): string
    {
        return $this->relevanceSortType;
    }

    public function getViewConfiguration(): ViewConfiguration
    {
        return $this->viewConfiguration;
    }
}
