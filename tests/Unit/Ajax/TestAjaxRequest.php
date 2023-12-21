<?php

declare(strict_types=1);

use URAZone\Ajax\AjaxRequest;
use URAZone\RequestDefinitions\DefinitionUsersList;

use PHPUnit\Framework\TestCase;
use Brain\Monkey\Functions;

class TestAjaxRequest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
        \Brain\Monkey\setUp();
    }

    public function tearDown(): void {
        \Brain\Monkey\tearDown();
        parent::tearDown();
    }
    public function testAdd()
    {
        // Arrange
        $ajaxRequest = new AjaxRequest();
        $requestDefinition = new DefinitionUsersList();

        // Act
        $result = $ajaxRequest->add($requestDefinition);

        // Use reflection to access the private property
        $reflection = new \ReflectionClass($ajaxRequest);
        $property = $reflection->getProperty('requests');
        $property->setAccessible(true);
        $requests = $property->getValue($ajaxRequest);

        // Assert
        $this->assertInstanceOf(AjaxRequest::class, $result);
        $this->assertContains($requestDefinition, $requests);
    }

    public function testRegisterRequests()
    {
    // Arrange
    $ajaxRequest = new AjaxRequest();
    $requestDefinition = new DefinitionUsersList();
    $ajaxRequest->add($requestDefinition);

    // Mock the add_action and add_option functions
    Functions\expect('add_action')->zeroOrMoreTimes();
    Functions\expect('add_option')->andReturn(true);
    Functions\expect('get_option')->andReturn(true);

    // Act
    $ajaxRequest->registerRequests();

    // Assert
    // Manually assert based on the expected behavior of registerRequests
    $action = $requestDefinition->action();

    // Get the callback added to wp_ajax_{$action} and wp_ajax_nopriv_{$action}
    $hook = $this->getRegisteredAction($action, "wp_ajax_{$action}");
    $this->assertHookHasCallback($hook, $action);

    $hookNoPriv = $this->getRegisteredAction($action, "wp_ajax_nopriv_{$action}");
    $this->assertHookHasCallback($hookNoPriv, $action);
    }

    private function getRegisteredAction(string $action, string $hook): array
    {
        global $wp_filter;

        $hook = isset($wp_filter[$hook]) ? $wp_filter[$hook] : [];

        return isset($hook[$action]) ? $hook[$action] : [];
    }

    private function assertHookHasCallback(array $hook, string $action)
    {
        $this->assertEmpty($hook);
        $this->assertIsArray($hook);
    
        foreach ($hook as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                $this->assertIsArray($callback);
                $this->assertArrayHasKey('function', $callback);
                $this->assertIsCallable($callback['function']);
    
                // Check if the expected callback matches the actual callback
                $this->assertEquals([$this->getMockBuilder(AjaxRequest::class)->getMock(), 'sendData'], $callback['function']);
            }
        }
    }


}
