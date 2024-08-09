<?php

declare(strict_types=1);

namespace Netgen\IbexaSearchFilter\Core\Values;

use Netgen\IbexaSearchFilter\Core\Values\Configuration\FilterConfiguration;
use Symfony\Component\HttpFoundation\Request;

class BaseRequest extends ValueObject
{
    public Request $request;
    public FilterConfiguration $filterConfiguration;

}
