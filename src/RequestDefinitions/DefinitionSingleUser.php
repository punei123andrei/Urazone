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

use URAZone\Ajax\ApiBase;

/**
 * Defines an object to be executed by the AjaxRequest class
 *
 * @package URAZone\RequestDefinitions
 * @since 1.0.1
 */
class DefinitionSingleUser implements RequestDefinition
{
    /**
     * Route.
     * @return string
     */
    public function route(): string
    {
        return ApiBase::baseUrl('/users');
    }

    /**
     * Headers.
     * @return array
     */
    public function headers(): array
    {
        return ApiBase::headers();
    }

    /**
     * Action
     * @return string
     */
    public function action(): string
    {
        return 'urazone_single_user';
    }

    /**
     * Data to be sent with the request.
     * @return array
     */
    public function data(): array
    {
        return ['userId'];
    }

    /**
     * Specifies if the data should be appended to the url
     * @return bool
     */
    public function appendParam(): bool
    {
        return true;
    }
}
