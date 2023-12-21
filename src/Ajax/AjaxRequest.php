<?php

/**
 * Inpsyde Users
 *
 * @package urazone_Users
 * @author  Punei Andrei <punei.andrei@gmail.com>
 * @license GNU General Public License v3.0
 */

declare(strict_types=1);

namespace URAZone\Ajax;

use URAZone\RequestDefinitions\RequestDefinition;

/**
 * Processes requests defined by entities
 *
 * @package URAZone\RequestDefinitions
 * @since 1.0.1
 */
class AjaxRequest
{
    /**
     * @var RequestDefinition[] $requests
     */
    private $requests = [];

    /**
     * Add a RequestDefinition to the list of requests for the AjaxRequest.
     *
     * @param RequestDefinition $request The RequestDefinition object to be added.
     *
     * @return AjaxRequest Returns the current AjaxRequest instance for method chaining.
     */
    public function add(RequestDefinition $request): AjaxRequest
    {
        $this->requests[] = $request;
        return $this;
    }

    /**
     * Register all defined requests by setting up corresponding Ajax actions.
     */
    public function registerRequests(): void
    {
        foreach ($this->requests as $request) {
            $route = $request->route();
            $headers = $request->headers();
            $action = $request->action();
            $data = $request->data();
            $appendParam = $request->appendParam();

            // Trigger a custom filter hook before registering the request
            $callback = apply_filters(
                'urazone_ajax_callback',
                function () use ($route, $headers, $data, $appendParam, $action) {
                    $this->sendData($route, $headers, $data, $appendParam, $action);
                },
                $request
            );

            $this->addAjaxAction($action, $callback);
        }
    }

    /**
     * Add an Ajax action for the specified action hook.
     *
     * @param string   $action   The unique identifier for the Ajax action.
     * @param callable $callback The callback function to be executed.
     */
    private function addAjaxAction(string $action, callable $callback)
    {
        add_action("wp_ajax_$action", $callback);
        add_action("wp_ajax_nopriv_$action", $callback);
    }

    /**
     * Send data to a specified route using an Ajax request.
     *
     * @param string $route       The target route for the Ajax request.
     * @param array  $headers     Associative array of headers to include in the request.
     * @param array  $data        Optional. Associative array of data to include in the request.
     * @param bool   $appendParam If true, appends a parameter to the route based on the
     * @param string $action      first value of the data array using RequestHelper methods.
     *
     */
    public function sendData(
        string $route,
        array $headers,
        array $data,
        bool $appendParam,
        string $action
    ) {

        do_action('urazone_before_send_ajax_data', $route, $headers, $data);

        if ($appendParam) {
            $param = reset(RequestHelper::returnPostData($data));
            $route = RequestHelper::appendParam($route, $param);
            $response = RequestHelper::makeGetRequest($route, [], $headers);
            wp_send_json($response);
        }

        $response = RequestHelper::cachedResults($route, [], $headers, $action);

        if (is_wp_error($response)) {
            wp_send_json_error($response->get_error_message());
        }

        wp_send_json($response);

        do_action('urazone_after_send_ajax_data', $response);
    }
}
