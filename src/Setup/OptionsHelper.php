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

use URAZone\Ajax\ApiBase;

/**
 *
 * Helps with setting otions
 *
 * @package URAZone\RequestDefinitions
 * @since 1.0.1
 */
class OptionsHelper
{
    /**
     * Renders the content for the options page.
     *
     * @return void
     */
    public static function renderOptionsPage(): void
    {
        ?>
        <div class="wrap">
            <form method="post" action="options.php">
                <?php
                settings_fields('urazone_user_options');
                do_settings_sections('urazone-user-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Adds a new options group, settings section + section field
     *
     * @return void
     */
    public static function initSettings(): void
    {
        $self = new self();
        register_setting('urazone_user_options', 'urazone_api_base');
        add_settings_section(
            'urazone_user_section',
            'Inpsyde User Settings',
            [$self, 'sectionCallback'],
            'urazone-user-settings'
        );
        add_settings_field(
            'urazone_user_input',
            'Inpsyde Option',
            [$self, 'inputCallback'],
            'urazone-user-settings',
            'urazone_user_section'
        );
    }

    /**
     * Section description
     *
     * @echo string
     */
    public function sectionCallback()
    {
        ?>
        <p><?php esc_html_e('Api Base URL', 'inpsyde'); ?></p>;
        <?php
    }

    /**
     * Section input
     *
     * @echo string
     */
    public function inputCallback()
    {
        $apiBaseValue = get_option('urazone_api_base');
        $defaultBase = ApiBase::API_BASE;
        $apiBase = $apiBaseValue ? $apiBaseValue : $defaultBase;
        ?>
        <input type='text' name='urazone_api_base' value='<?php echo esc_attr($apiBase); ?>' />
        <?php
    }
}
