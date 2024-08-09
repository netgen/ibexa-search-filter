<?php

declare(strict_types=1);

namespace Netgen\IbexaSearchFilter\Core\Values;

class FilterRequest extends BaseRequest
{
    public string $searchTerm;
    public int $page;
    public int $hitsPerPage;
}
