<?php

namespace Modules\Crawler\Infrastructure\Utils;

use Modules\Crawler\Domain\Contracts\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class UuidGenerator
 * @package Modules\Crawler\Infrastructure\Utils
 *
 * This class implements the UuidGeneratorInterface to generate UUIDs.
 */
class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
