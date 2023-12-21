<?php 

declare(strict_types=1);

use URAZone\Setup\Setup;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;

class TestSetup extends TestCase 
{
    public function setUp(): void {
        parent::setUp();
        Monkey\setUp();
    }


    public function tearDown(): void {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function testAddOptionsPage() {
        // Mock the add_options_page function to return false
        Monkey\Functions\expect('add_options_page')
            ->once()
            ->andReturn(false);

        // Call the mocked add_options_page function
        $result = add_options_page('Page Title', 'Menu Title', 'manage_options', 'urazone_settings', function () {
            // This callback won't be executed since we are mocking the function
        });

        // Assert that the return value is false
        $this->assertFalse($result);
    }

    public function testAddStyle() {
        // Arrange
        $setup = new Setup();

        // Mock the wp_enqueue_style function
        Functions\when('wp_enqueue_style')->justReturn(true);

        // Act
        $result = $setup->addStyle('test_style', 'test.css', ['dependency'], '1.0', 'all');

        // Assert
        $this->assertInstanceOf(Setup::class, $result);
    }

    public function testAddScript() {
        // Arrange
        $setup = new Setup();

        // Mock the wp_enqueue_script function
        Functions\expect('wp_enqueue_script')
            ->zeroOrMoreTimes()
            ->with('test_script', 'test.js', ['dependency'], '1.0', true)
            ->andReturn(true);

        // Act
        $result = $setup->addScript('test_script', 'test.js', ['dependency'], '1.0', true);

        // Assert
        $this->assertInstanceOf(Setup::class, $result);
    }

    public function testLocalizeScript() {
        // Arrange
        $setup = new Setup();

        // Mock admin_url and wp_create_nonce functions
        Functions\expect('admin_url')
            ->zeroOrMoreTimes()
            ->andReturn('http://example.com');

        Functions\expect('wp_create_nonce')
            ->zeroOrMoreTimes()
            ->andReturn('mocked_nonce');

        // Mock the wp_register_script, wp_localize_script, and wp_enqueue_script functions
        Functions\expect('wp_register_script')
            ->zeroOrMoreTimes();

        Functions\expect('wp_localize_script')
            ->zeroOrMoreTimes()
            ->andReturn(true);

        Functions\expect('wp_enqueue_script')
            ->zeroOrMoreTimes();

        // Act
        $result = $setup->localizeScript(
            'test_script',
            'test.js',
            ['dependency'],
            '1.0',
            true,
            'test_page'
        );

        // Assert
        $this->assertInstanceOf(Setup::class, $result);
    }
}
