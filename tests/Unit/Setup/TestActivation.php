<?php 

declare(strict_types=1);

use URAZone\Setup\Activation;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;

class TestActivation extends TestCase {
    public function setUp(): void {
        parent::setUp();
        Monkey\setUp();
    }

    public function tearDown(): void {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function testActivate(){

        // Mock wp_doing_cron() to return a specific value
        Functions\expect('wp_doing_cron')
        ->andReturn(false); 

        // Mock the flush_rewrite_rules function
        Functions\expect('flush_rewrite_rules')
        ->zeroOrMoreTimes();

        Functions\expect('do_action')
        ->zeroOrMoreTimes()
        ->with('urazone_before_activate'); 

        Functions\expect('apply_filters')
        ->zeroOrMoreTimes()
        ->with('urazone_page_content', 'content'); 

        Functions\when('get_current_user_id')->justReturn(1);

        define('OBJECT', 'mocked_object_constant');

        Functions\when('get_page_by_title')->justReturn((object) ['ID' => 123]);

        Functions\when('wp_insert_post')->justReturn(1);

        $result = Activation::createTestPage('content');

        $this->assertIsInt($result);
    }

}
