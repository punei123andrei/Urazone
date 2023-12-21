<?php 

declare(strict_types=1);

use URAZone\Setup\OptionsHelper;
use URAZone\Setup\Setup;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;

class TestOptionsHelper extends TestCase {
    public function setUp(): void {
        parent::setUp();
        Monkey\setUp();
    }

    public function tearDown(): void {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function testRenderOptionsPage() {
        // Create an instance of OptionsHelper
        $optionsHelper = new OptionsHelper();
        
        // Set up expectations for the mocked functions
        Functions\expect('settings_fields')
            ->zeroOrMoreTimes()
            ->with('urazone_user_options');

        // Use andReturns to specify a callback function for do_settings_sections
        Functions\expect('do_settings_sections')
            ->zeroOrMoreTimes()
            ->with('urazone-user-settings')
            ->andReturns('input');

        Functions\expect('submit_button')
            ->zeroOrMoreTimes();

        // Start output buffering to capture echoed output
        ob_start();
        // Call the method you want to test
        $optionsHelper->renderOptionsPage();
        // Capture the output and stop output buffering
        $output = ob_get_clean();
        // Check if the output contains the expected HTML
        $this->assertStringContainsString('form', $output);
    }

    public function testInitSettings() {
    // Create an instance of Setup
    $setup = new Setup();

    // Set up expectations for the mocked functions
    Functions\expect('register_setting')
        ->zeroOrMoreTimes()
        ->with(
            'urazone_user_options',
            'urazone_api_base',
            ['sectionCallback'],
            'urazone-user-settings'
        );

    // Call the method you want to test
    $result = $setup->addOptionsPage('Page Title', 'Menu Title');

    // Additional assertions based on your specific logic
    $this->assertInstanceOf(Setup::class, $result);

    }

    public function testsectionCallback(){
        $optionsHelper = new OptionsHelper();

        Functions\when('esc_html_e')->justReturn('Api Base URL');

        ob_start();
        $optionsHelper->sectionCallback();
        $output = ob_get_clean();

        $this->assertStringContainsString('<p>', $output);
    }

    public function testinputCallback(){
        $optionsHelper = new OptionsHelper();

        Functions\expect('get_option')
        ->zeroOrMoreTimes()
        ->with('Api Base URL', 'inpsyde')
        ->andReturnUsing(function () {
            // Simulate logic to return either false or a URL string
            return rand(0, 1) === 0 ? false : 'https://example.com/api';
        });
        Functions\when('esc_attr')->justReturn('https://example.com/api');
        
        ob_start();
        $optionsHelper->inputCallback();
        $output = ob_get_clean();

        $this->assertStringContainsString('input', $output);
    }
}
