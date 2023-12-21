<?php

/**
 * Inpsyde Users
 *
 * @package   Inpsyde Users
 * @author    Punei Andrei <punei.andrei@gmail.com>
 * @license   GNU General Public License v3.0
 */

declare(strict_types=1);

namespace URAZone\RequestDefinitions;

/**
 * Defines a request to be implemented by entities
 *
 * @package URAZone\RequestDefinitions
 * @since 1.0.1
 */
interface RequestDefinition
{
    /**
     * Route.
     * @return string
     */
    public function route(): string;

    /**
     * Headers.
     * @return array
     */
    public function headers(): array;

    /**
     * The Ajax action that will trigger the function
     * @return string
     */
    public function action(): string;

    /**
     * Data to be sent with the request.
     * @return array
     */
    public function data(): array;

    /**
     * If the data param should be appended to the url
     * @return bool
     */
    public function appendParam(): bool;
}
