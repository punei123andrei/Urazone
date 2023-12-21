<?php

/**
 * Inpsyde Users
 *
 * @package   Inpsyde Users
 * @author    Punei Andrei <punei.andrei@gmail.com>
 * @license   GNU General Public License v3.0
 */

 declare(strict_types=1);

namespace URAZone\Ajax;

/**
 * Defines a base for comunicating with the api
 *
 * @package URAZone\RequestDefinitions
 * @since 1.0.1
 */
class ApiBase
{
   /**
    * @var string The api base url
    */
    public const API_BASE = 'https://jsonplaceholder.typicode.com';

    /**
     * The version of API used
     *
     * @return string
     */
    public static function version(): string
    {
        return 'v1';
    }
    /**
     * Get the base url for API
     *
     * @param string $endpoint
     * @param bool $use_service
     * @param bool $is_use_version
     * @return string
     */
    public static function baseUrl(string $endpoint, bool $useService = true): string
    {
        $apiBaseValue = get_option('urazone_api_base');
        $apiBase = $apiBaseValue ? $apiBaseValue : self::API_BASE;
        return trailingslashit($apiBase) . ltrim($endpoint, '/');
    }
    /**
     * Get the headers with the authorization token
     *
     * @param array $items
     * @return string[]
     */
    public static function headers(array $items = []): array
    {
          $items = array_merge([
              'Accept' => 'application/json',
          ], $items);
          return $items;
    }
}
