<?php

declare(strict_types=1);

namespace URAZone\Ajax;
use URAZone\Ajax\RequestHelper;
use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;


class TestRequestHelper extends TestCase
{

    public function setUp(): void {
        parent::setUp();
        Monkey\setUp();
    }

    public function tearDown(): void {
        Monkey\tearDown();
        parent::tearDown();
    }
    
    public function testMakeGetRequest()
    {
        // Arrange
        $url = 'https://example.com';
        $data = ['param' => 'value'];
        $headers = ['Content-Type' => 'application/json'];

        // Mock wp_remote_get function
        Functions\expect('wp_remote_get')
            ->with($url, [
                'body' => $data,
                'headers' => $headers,
                'timeout' => 15,
                'redirection' => 5,
                'blocking' => true,
                'httpversion' => '1.1',
                'sslverify' => false,
            ])
            ->andReturn(['body' => 'Mocked API response']);

        // Mock wp_remote_retrieve_body function
        Functions\expect('wp_remote_retrieve_body')
            ->with(['body' => 'Mocked API response'])
            ->andReturn('Mocked API response body');

        // Mock checks
        Functions\when('is_wp_error')->justReturn(false);
        Functions\when('wp_remote_head')->justReturn((array) ['url' => $url]);
        Functions\when('wp_remote_retrieve_response_code')->justReturn(200);
            
        // Act
        $result = RequestHelper::makeGetRequest($url, $data, $headers);

        // Assert
        $this->assertEquals('Mocked API response body', $result);
    }

    public function testVerifyNonce()
    {
        // Arrange
        $_POST['token'] = 'mock_nonce';
        $action = 'mock_action';

        Functions\expect('is_wp_error')->andReturn(false);
        Functions\expect('sanitize_text_field')->andReturn(true);
        Functions\expect('wp_verify_nonce')->andReturn(true);

        // Mock wp_unslash function
        Functions\expect('wp_unslash')->andReturn('');

        // Act
        $result = RequestHelper::verifyNonce($action);

        // Assert
        $this->assertTrue($result);
    }

    public function testAppendParam()
    {
        // Arrange
        $route = 'https://example.com/api';
        $data = 'user';

        Functions\expect('is_wp_error')->andReturn(false);
        Functions\expect('wp_unslash')->andReturn('');

        // Act
        $result = RequestHelper::appendParam($route, $data);

        // Assert
        $this->assertEquals('https://example.com/api/user', $result);
    }

    public function testReturnPostData()
    {
        // Arrange
        $_POST['token'] = 'mock_nonce';
        $_POST['key1'] = 'value1';
        $_POST['key2'] = 'value2';
        
        $keys = ['key1', 'key2'];
        $nonceAction = 'mock_nonce_action';
        
        Functions\expect('wp_verify_nonce')->andReturn(true);
        Functions\expect('sanitize_text_field')->andReturn('');
        
        // Mock wp_unslash function
        Functions\expect('wp_unslash')->andReturn('');
        
        // Act
        $result = RequestHelper::returnPostData($keys, $nonceAction);
        
        // Assert
        $expectedResult = [0 => '', 1 => ''];
        $this->assertEquals($expectedResult, $result);
    }

    public function testIsApiReachable(){

        // Arrange
        $url = 'https://example.com/api';

        // Act
        Functions\when('wp_remote_head')->justReturn((array) ['url' => $url]);

        Functions\expect('is_wp_error')->andReturn(false);

        Functions\when('wp_remote_retrieve_response_code')->justReturn(200);

        // Assert
        $result = RequestHelper::isApiREachable($url);

        // Assert
        $this->assertTrue($result);
        
    }
}
