<?php

declare(strict_types=1);

namespace Netgen\IbexaSearchFilter\Core\Values;


class FilterResponse extends ValueObject
{
    public ?string $query;
    public ?SelectedCategory $selectedCategory;
    public Categories $categories;
    public SelectedFacets $selectedFacets;
    public Facets $facets;
    public Pager $pager;
}
