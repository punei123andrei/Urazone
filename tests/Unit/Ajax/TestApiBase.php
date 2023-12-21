<?php

declare(strict_types=1);

namespace URAZone\Ajax;
use URAZone\Ajax\ApiBase;
use PHPUnit\Framework\TestCase;
use Brain\Monkey\Functions;

class TestApiBase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        \Brain\Monkey\setUp();
    }

    public function tearDown(): void
    {
        \Brain\Monkey\tearDown();
        parent::tearDown();
    }

    public function testVersion()
    {
        // Act
        $result = ApiBase::version();

        // Assert
        $this->assertEquals('v1', $result);
    }

    public function testBaseUrl()
    {
        // Arrange
        $endpoint = 'posts';

        // Mock get_option
        Functions\when('get_option')->justReturn('');

        // Act
        $result = ApiBase::baseUrl($endpoint);

        // Assert
        $this->assertEquals('https://jsonplaceholder.typicode.com/posts', $result);
    }

    public function testBaseUrlWithCustomApiBase()
    {
        // Arrange
        $endpoint = 'comments';

        // Mock get_option
        Functions\when('get_option')->justReturn('https://custom.api');

        // Act
        $result = ApiBase::baseUrl($endpoint);

        // Assert
        $this->assertEquals('https://custom.api/comments', $result);
    }

    public function testHeaders()
    {
        // Act
        $result = ApiBase::headers();

        // Assert
        $this->assertEquals(['Accept' => 'application/json'], $result);
    }

    public function testHeadersWithAdditionalItems()
    {
        // Arrange
        $additionalItems = ['Content-Type' => 'application/json'];

        // Act
        $result = ApiBase::headers($additionalItems);

        // Assert
        $this->assertEquals(['Accept' => 'application/json', 'Content-Type' => 'application/json'], $result);
    }
}
