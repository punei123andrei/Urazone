<?php

/**
 * Inpsyde Users API
 *
 * @package   Inpsyde Users API
 * @author    Punei Andrei <punei.andrei@gmail.com>
 * @license   GNU General Public License v3.0
 */

declare(strict_types=1);

namespace URAZone\Setup;

/**
 * Runs specific action on activation
 *
 * @package URAZone\RequestDefinitions
 * @since 1.0.1
 */
class Activation
{
    /**
     * Run activation Setup
     */
    public static function activate()
    {
        if (wp_doing_cron()) {
            return;
        }

        do_action('urazone_before_activate');

        flush_rewrite_rules();

        do_action('urazone_after_flush_rewrite_rules');

        $pageContent = apply_filters('urazone_page_content', '
        <div id="urazone-content">
            <table id="urazone-table"></table>
            <div class="urazone-single-user"></div>
        </div>
        ');

        self::createTestPage($pageContent); 
    }

    /**
     * Create the test page
     *
     * @param mixed $pageContent
     */
    public static function createTestPage(mixed $pageContent): int
    {

        do_action('urazone_before_create_test_page');

        $authorId = get_current_user_id();

        $page = get_page_by_title('Urazone Users Test', OBJECT, 'page');
        
        if (!$page) {
            $newPage = [
                'post_title' => 'Urazone Users Test',
                'post_content' => $pageContent,
                'post_status' => 'publish',
                'post_author' => $authorId,
                'post_type' => 'page',
            ];

           $pageId = wp_insert_post($newPage);

           return $pageId;
            
        }
        do_action('urazone_after_create_test_page');

        return $page->ID;
    }
}
