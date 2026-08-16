<?php

declare(strict_types=1);

namespace RhBlocks;

use RhBlueprint\Core\Core;
use RhBlueprint\Core\UpdateChecker;

/**
 * Bootstrap von rh-blocks. Hängt am Core-Hook `rh-blueprint/core/booted` (init),
 * dort werden die Blöcke + die Kategorie registriert. Braucht nur den Core.
 * Keine Settings-Seite: das Modul liefert nur Blöcke.
 */
final class Plugin
{
    public static function boot(): void
    {
        add_action('plugins_loaded', static function (): void {
            (new UpdateChecker('rh-blocks', RHBLOCKS_PLUGIN_FILE))->boot();
        }, 0);

        add_action('rh-blueprint/core/booted', [self::class, 'onCoreBooted']);
    }

    public static function onCoreBooted(Core $core): void
    {
        (new Blocks())->register();
    }
}
