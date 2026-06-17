<?php

/**
 * Plugin Name:       RH Blocks
 * Plugin URI:        https://github.com/herbeckrobin/rh-blocks
 * Update URI:        https://github.com/herbeckrobin/rh-blocks
 * Description:       Bibliothek wiederkehrender Custom Blocks. Start: Link-Block (klickbare Group/Card). Teil der rh-blueprint Kollektion.
 * Version:           0.1.1
 * Requires at least: 6.5
 * Requires PHP:      8.1
 * Author:            Robin Herbeck
 * Author URI:        https://robinherbeck.de
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       rh-blocks
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

define('RHBLOCKS_VERSION', '0.1.1');
define('RHBLOCKS_PLUGIN_FILE', __FILE__);
define('RHBLOCKS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RHBLOCKS_PLUGIN_URL', plugin_dir_url(__FILE__));

$rhblocks_autoload = RHBLOCKS_PLUGIN_DIR . 'vendor/autoload.php';

if (! is_readable($rhblocks_autoload)) {
    add_action('admin_notices', static function (): void {
        echo '<div class="notice notice-error"><p><strong>RH Blocks:</strong> Composer-Dependencies fehlen. Bitte <code>composer install</code> im Plugin-Verzeichnis ausführen.</p></div>';
    });
    return;
}

require_once $rhblocks_autoload;

RhBlocks\Plugin::boot();
