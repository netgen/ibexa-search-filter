<?php

declare(strict_types=1);

namespace Netgen\IbexaSearchFilter\Core\Values;

use JsonSerializable;
use RuntimeException;

use function get_object_vars;
use function property_exists;
use function sprintf;

abstract class ValueObject implements JsonSerializable
{
    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties = [])
    {
        foreach ($properties as $key => $value) {
            if (!property_exists($this, $key)) {
                throw new RuntimeException(
                    sprintf(
                        'Property "%s" does not exist',
                        $key,
                    ),
                );
            }

            $this->{$key} = $value;
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
