<?php

declare(strict_types=1);

namespace Netgen\IbexaSearchFilter\Core\Values\Configuration;

use JsonSerializable;
use LogicException;
use Symfony\Component\HttpFoundation\Request;

final class ViewConfiguration implements JsonSerializable
{
    /**
     * @param string[] $enabledFacets
     * @param string[] $enabledSortTypes
     * @param ?array<string, array<int, string>> $fixedFacets
     * @param ?string[] $fixedContributors
     * @param int[] $maxPerPageChoices
     */
    public function __construct(
        private readonly string $pageType,
        private ?string $rootRoute,
        private array $enabledFacets,
        private array $enabledSortTypes,
        private bool $routing,
        private bool $categoryPathRouting,
        private bool $linkedCategories,
        private string $categoryContainerTaxonCode,
        private ?array $fixedFacets,
        private ?string $fixedCategory,
        private ?array $fixedContributors,
        private readonly string $routeApiFilter,
        private readonly string $routeApiFacet,
        private readonly string $routeApiPager,
        private array $maxPerPageChoices,
        private int $defaultMaxPerPage,
        private string $defaultSortType,
        private bool $showCategoryCount,
        private bool $showCategoryBack,
        private bool $showCategoryBackHome,
        private bool $showCategories,
        private bool $showFacets,
        private bool $showPagination,
        private bool $showProducts,
        private bool $showSort,
        private bool $showClearSelection,
        private bool $showSelectedFacets,
        private bool $showSelectedCategories,
        private bool $showSelectedQuery,
        private bool $showNbResults,
        private readonly string $symfonyEnvironment,
    ) {
    }

    public function getPageType(): string
    {
        return $this->pageType;
    }

    public function getRootRoute(): ?string
    {
        return $this->rootRoute;
    }

    /**
     * @return string[]
     */
    public function getEnabledFacets(): array
    {
        return $this->enabledFacets;
    }

    /**
     * @return string[]
     */
    public function getEnabledSortTypes(): array
    {
        return $this->enabledSortTypes;
    }

    public function isRouting(): bool
    {
        return $this->routing;
    }

    public function isCategoryPathRouting(): bool
    {
        return $this->categoryPathRouting;
    }

    public function isLinkedCategories(): bool
    {
        return $this->linkedCategories;
    }

    public function getCategoryContainerTaxonCode(): string
    {
        return $this->categoryContainerTaxonCode;
    }

    /**
     * @return ?array<string, array<int, string>>
     */
    public function getFixedFacets(): ?array
    {
        return $this->fixedFacets;
    }

    public function getFixedCategory(): ?string
    {
        return $this->fixedCategory;
    }

    /**
     * @return ?string[]
     */
    public function getFixedContributors(): ?array
    {
        return $this->fixedContributors;
    }

    public function getRouteApiFilter(): string
    {
        return $this->routeApiFilter;
    }

    public function getRouteApiFacet(): string
    {
        return $this->routeApiFacet;
    }

    public function getRouteApiPager(): string
    {
        return $this->routeApiPager;
    }

    /**
     * @return int[]
     */
    public function getMaxPerPageChoices(): array
    {
        return $this->maxPerPageChoices;
    }

    public function getDefaultMaxPerPage(): int
    {
        return $this->defaultMaxPerPage;
    }

    public function getDefaultSortType(): string
    {
        return $this->defaultSortType;
    }

    public function isShowCategoryCount(): bool
    {
        return $this->showCategoryCount;
    }

    public function isShowCategoryBack(): bool
    {
        return $this->showCategoryBack;
    }

    public function isShowCategoryBackHome(): bool
    {
        return $this->showCategoryBackHome;
    }

    public function isShowCategories(): bool
    {
        return $this->showCategories;
    }

    public function isShowFacets(): bool
    {
        return $this->showFacets;
    }

    public function isShowPagination(): bool
    {
        return $this->showPagination;
    }

    public function isShowProducts(): bool
    {
        return $this->showProducts;
    }

    public function isShowSort(): bool
    {
        return $this->showSort;
    }

    public function isShowClearSelection(): bool
    {
        return $this->showClearSelection;
    }

    public function isShowSelectedFacets(): bool
    {
        return $this->showSelectedFacets;
    }

    public function isShowSelectedCategories(): bool
    {
        return $this->showSelectedCategories;
    }

    public function isShowSelectedQuery(): bool
    {
        return $this->showSelectedQuery;
    }

    public function isShowNbResults(): bool
    {
        return $this->showNbResults;
    }

    public function getSymfonyEnvironment(): string
    {
        return $this->symfonyEnvironment;
    }

    /**
     * @param string[] $enabledFacets
     */
    public function setEnabledFacets(array $enabledFacets): void
    {
        $this->enabledFacets = $enabledFacets;
    }

    /**
     * @param string[] $enabledSortTypes
     */
    public function setEnabledSortTypes(array $enabledSortTypes): void
    {
        $this->enabledSortTypes = $enabledSortTypes;
    }

    public function setRouting(bool $routing): void
    {
        $this->routing = $routing;
    }

    public function setCategoryPathRouting(bool $categoryPathRouting): void
    {
        $this->categoryPathRouting = $categoryPathRouting;
    }

    public function setLinkedCategories(bool $linkedCategories): void
    {
        $this->linkedCategories = $linkedCategories;
    }

    public function setFixedCategory(string $code): void
    {
        $this->fixedCategory = $code;
    }

    /**
     * @param array<string, array<int, string>> $facets
     */
    public function setFixedFacets(array $facets): void
    {
        $this->fixedFacets = $facets;
    }

    /**
     * @return string[]
     */
    public function getFixedFacetValues(FacetDefinition $definition): array
    {
        $identifier = $definition->parameterName;

        if (!isset($this->fixedFacets[$identifier])) {
            throw new LogicException('Facet data was not found in the view configuration');
        }

        $values = $this->fixedFacets[$identifier];

        if (count($values) === 0) {
            throw new LogicException(
                sprintf(
                    'No values are set for fixed facet "%s"',
                    $identifier,
                ),
            );
        }

        if ($definition->multiple) {
            return $values;
        }

        return [reset($values)];
    }

    public function setRootRoute(string $route): void
    {
        $this->rootRoute = $route;
    }

    /**
     * @param string[] $contributors
     */
    public function setFixedContributors(array $contributors): void
    {
        $this->fixedContributors = $contributors;
    }

    public function setCategoryContainerTaxonCode(string $code): void
    {
        $this->categoryContainerTaxonCode = $code;
    }

    /**
     * @param int[] $maxPerPageChoices
     */
    public function setMaxPerPageChoices(array $maxPerPageChoices): void
    {
        $this->maxPerPageChoices = $maxPerPageChoices;
    }

    public function setDefaultMaxPerPage(int $defaultMaxPerPage): void
    {
        $this->defaultMaxPerPage = $defaultMaxPerPage;
    }

    public function setDefaultSortType(string $defaultSortType): void
    {
        $this->defaultSortType = $defaultSortType;
    }

    public function setShowCategoryCount(bool $state): void
    {
        $this->showCategoryCount = $state;
    }

    public function setShowCategoryBack(bool $state): void
    {
        $this->showCategoryBack = $state;
    }

    public function setShowCategoryBackHome(bool $state): void
    {
        $this->showCategoryBackHome = $state;
    }

    public function setShowCategories(bool $state): void
    {
        $this->showCategories = $state;
    }

    public function setShowFacets(bool $state): void
    {
        $this->showFacets = $state;
    }

    public function setShowPagination(bool $state): void
    {
        $this->showPagination = $state;
    }

    public function setShowProducts(bool $state): void
    {
        $this->showProducts = $state;
    }

    public function setShowSort(bool $state): void
    {
        $this->showSort = $state;
    }

    public function setShowClearSelection(bool $state): void
    {
        $this->showClearSelection = $state;
    }

    public function setShowSelectedFacets(bool $state): void
    {
        $this->showSelectedFacets = $state;
    }

    public function setShowSelectedCategories(bool $state): void
    {
        $this->showSelectedCategories = $state;
    }

    public function setShowSelectedQuery(bool $state): void
    {
        $this->showSelectedQuery = $state;
    }

    public function setShowNbResults(bool $state): void
    {
        $this->showNbResults = $state;
    }

    public function setFromRequest(Request $request): void
    {
        if ($request->query->has('enabledFacets')) {
            /** @var string[] $enabledFacets */
            $enabledFacets = $request->query->get('enabledFacets');

            $this->setEnabledFacets($enabledFacets);
        }

        if ($request->query->has('enabledSortTypes')) {
            /** @var string[] $enabledSortTypes */
            $enabledSortTypes = $request->query->get('enabledSortTypes');

            $this->setEnabledSortTypes($enabledSortTypes);
        }

        if ($request->query->has('fixedCategory')) {
            /** @var string $fixedCategory */
            $fixedCategory = $request->query->get('fixedCategory');

            $this->setFixedCategory($fixedCategory);
        }

        if ($request->query->has('fixedFacets')) {
            /** @var array<string, array<int, string>> $fixedFacets */
            $fixedFacets = $request->query->get('fixedFacets');

            $this->setFixedFacets($fixedFacets);
        }

        if ($request->query->has('fixedContributors')) {
            /** @var string[] $fixedContributors */
            $fixedContributors = $request->query->get('fixedContributors');

            $this->setFixedContributors($fixedContributors);
        }

        if ($request->query->has('categoryContainerTaxonCode')) {
            /** @var string $categoryContainerTaxonCode */
            $categoryContainerTaxonCode = $request->query->get('categoryContainerTaxonCode');

            $this->setCategoryContainerTaxonCode($categoryContainerTaxonCode);
        }

        if ($request->query->has('maxPerPageChoices')) {
            /** @var int[] $maxPerPageChoices */
            $maxPerPageChoices = $request->query->get('maxPerPageChoices');

            $this->setMaxPerPageChoices($maxPerPageChoices);
        }

        if ($request->query->has('defaultMaxPerPage')) {
            $defaultMaxPerPage = $request->query->getInt('defaultMaxPerPage');

            $this->setDefaultMaxPerPage($defaultMaxPerPage);
        }

        if ($request->query->has('defaultSortType')) {
            $defaultSortType = $request->query->get('defaultSortType');

            $this->setDefaultSortType($defaultSortType);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'pageType' => $this->getPageType(),
            'rootRoute' => $this->getRootRoute(),
            'enabledFacets' => $this->getEnabledFacets(),
            'enabledSortTypes' => $this->getEnabledSortTypes(),
            'routing' => $this->isRouting(),
            'categoryPathRouting' => $this->isCategoryPathRouting(),
            'linkedCategories' => $this->isLinkedCategories(),
            'categoryContainerTaxonCode' => $this->getCategoryContainerTaxonCode(),
            'routeApiFilter' => $this->getRouteApiFilter(),
            'routeApiFacet' => $this->getRouteApiFacet(),
            'routeApiPager' => $this->getRouteApiPager(),
            'fixedCategory' => $this->getFixedCategory(),
            'fixedFacets' => $this->getFixedFacets(),
            'fixedContributors' => $this->getFixedContributors(),
            'maxPerPageChoices' => $this->getMaxPerPageChoices(),
            'defaultMaxPerPage' => $this->getDefaultMaxPerPage(),
            'defaultSortType' => $this->getDefaultSortType(),
            'showCategoryCount' => $this->isShowCategoryCount(),
            'showCategoryBack' => $this->isShowCategoryBack(),
            'showCategoryBackHome' => $this->isShowCategoryBackHome(),
            'showCategories' => $this->isShowCategories(),
            'showFacets' => $this->isShowFacets(),
            'showPagination' => $this->isShowPagination(),
            'showProducts' => $this->isShowProducts(),
            'showSort' => $this->isShowSort(),
            'showClearSelection' => $this->isShowClearSelection(),
            'showSelectedFacets' => $this->isShowSelectedFacets(),
            'showSelectedCategories' => $this->isShowSelectedCategories(),
            'showSelectedQuery' => $this->isShowSelectedQuery(),
            'showNbResults' => $this->isShowNbResults(),
        ];
    }
}

