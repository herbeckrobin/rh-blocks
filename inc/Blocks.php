<?php

declare(strict_types=1);

namespace RhBlocks;

/**
 * Registriert die Block-Bibliothek + die eigene Kategorie.
 *
 * Buildless: block.json wird serverseitig registriert (liefert Attribute, Supports,
 * render.php), das Editor-Script lädt buildless über window.wp.* und bekommt die
 * block.json-Metadaten per wp_localize_script gespiegelt (eine Quelle, kein Build).
 */
final class Blocks
{
    public const CATEGORY = 'rh-blocks';

    public function register(): void
    {
        add_filter('block_categories_all', [$this, 'addCategory']);

        $this->registerLinkBlock();
    }

    /**
     * @param array<int, array<string, mixed>> $categories
     * @return array<int, array<string, mixed>>
     */
    public function addCategory(array $categories): array
    {
        foreach ($categories as $cat) {
            if (($cat['slug'] ?? '') === self::CATEGORY) {
                return $categories;
            }
        }

        array_unshift($categories, [
            'slug' => self::CATEGORY,
            'title' => __('RH Blöcke', 'rh-blocks'),
            'icon' => null,
        ]);

        return $categories;
    }

    private function registerLinkBlock(): void
    {
        $dir = RHBLOCKS_PLUGIN_DIR . 'blocks/link-block';
        $url = RHBLOCKS_PLUGIN_URL . 'blocks/link-block';

        $js = $dir . '/index.js';
        $css = $dir . '/style.css';
        $json = $dir . '/block.json';
        if (! file_exists($js) || ! file_exists($json)) {
            return;
        }

        wp_register_script(
            'rh-link-block-editor',
            $url . '/index.js',
            ['wp-blocks', 'wp-block-editor', 'wp-element', 'wp-components', 'wp-i18n'],
            (string) filemtime($js),
            true
        );

        // block.json-Metadaten in den Editor spiegeln (registerBlockType nimmt das Objekt).
        $meta = json_decode((string) file_get_contents($json), true);
        wp_localize_script('rh-link-block-editor', 'rhLinkBlockMeta', is_array($meta) ? $meta : []);

        if (file_exists($css)) {
            wp_register_style('rh-link-block', $url . '/style.css', [], (string) filemtime($css));
        }

        register_block_type($dir);
    }
}
