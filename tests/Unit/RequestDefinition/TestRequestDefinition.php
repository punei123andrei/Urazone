<?php

declare(strict_types=1);

namespace URAZone\Ajax;

use URAZone\RequestDefinitions\RequestDefinition;
use PHPUnit\Framework\TestCase;

class TestRequestDefinition extends TestCase
{
    public function testRoute()
    {
        // Create a mock of the RequestDefinition interface
        $mockRequestDefinition = $this->getMockForAbstractClass(RequestDefinition::class);

        // Call the route method
        $result = $mockRequestDefinition->route();

        // Assert that the result is a string
        $this->assertIsString($result);
    }

    public function testHeaders()
    {
        // Create a mock of the RequestDefinition interface
        $mockRequestDefinition = $this->getMockForAbstractClass(RequestDefinition::class);

        // Call the headers method
        $result = $mockRequestDefinition->headers();

        // Assert that the result is an array
        $this->assertIsArray($result);
    }

    public function testAction()
    {
        // Create a mock of the RequestDefinition interface
        $mockRequestDefinition = $this->getMockForAbstractClass(RequestDefinition::class);

        // Call the action method
        $result = $mockRequestDefinition->action();

        // Assert that the result is a string
        $this->assertIsString($result);
    }

    public function testData()
    {
        // Create a mock of the RequestDefinition interface
        $mockRequestDefinition = $this->getMockForAbstractClass(RequestDefinition::class);

        // Call the data method
        $result = $mockRequestDefinition->data();

        // Assert that the result is an array
        $this->assertIsArray($result);
    }
}
