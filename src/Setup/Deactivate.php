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
 * Runs specific action upon deactivation
 *
 * @package URAZone\RequestDefinitions
 * @since 1.0.1
 */

class Deactivate
{
    /**
     * Deactivate the functionality associated with the plugin or module.
     */
    public static function deactivate()
    {
        return self::removeTestPage();
    }

    /**
    * Remove a test page associated with the plugin.
    */
    public static function removeTestPage()
    {
        $page = get_page_by_title('Urazone Users Test', OBJECT, 'page');

        if ($page) {
            return wp_delete_post($page->ID, true);
        }
        return false;
    }
}
