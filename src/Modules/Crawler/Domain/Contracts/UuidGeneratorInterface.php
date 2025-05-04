<?php 

namespace Modules\Crawler\Domain\Contracts;

/**
 * Interface UuidGeneratorInterface
 * @package Modules\Crawler\Domain\Contracts
 *
 * This interface defines the contract for a UUID generator.
 */
interface UuidGeneratorInterface
{
    /**
     * Generate a new UUID.
     *
     * @return string The generated UUID.
     */
    public function generate(): string;
}