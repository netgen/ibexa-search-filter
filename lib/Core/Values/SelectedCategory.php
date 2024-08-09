<?php

declare(strict_types=1);

namespace Netgen\IbexaSearchFilter\Core\Values;


final class SelectedCategory extends ValueObject
{
    public string $code;
    public string $label;
    public int $count;
}
