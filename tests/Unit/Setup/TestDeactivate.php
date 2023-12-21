<?php 

declare(strict_types=1);

use URAZone\Setup\Deactivate;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;

class TestDeactivate extends TestCase {
    public function setUp(): void {
        parent::setUp();
        Monkey\setUp();
    }

    public function tearDown(): void {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function testDeactivate(){

        define('OBJECT', 'mocked_object_constant');

        Functions\when('get_page_by_title')->justReturn((object) ['ID' => 123]);

        Functions\expect('wp_delete_post')->zeroOrMoreTimes()->andReturn((object) ['ID' => 123]);

        $result = Deactivate::removeTestPage();

        $this->assertIsObject($result);
    }

}
