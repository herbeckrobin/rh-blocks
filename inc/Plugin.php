<?php

declare(strict_types=1);

namespace RhBlocks;

use RhBlueprint\Core\Core;

/**
 * Bootstrap von rh-blocks. Hängt am Core-Hook `rh-blueprint/core/booted` (init),
 * dort werden die Blöcke + die Kategorie registriert. Braucht nur den Core.
 * Keine Settings-Seite: das Modul liefert nur Blöcke.
 */
final class Plugin
{
    public static function boot(): void
    {
        if (class_exists(UpdateChecker::class)) {
            (new UpdateChecker())->boot();
        }

        add_action('rh-blueprint/core/booted', [self::class, 'onCoreBooted']);
    }

    public static function onCoreBooted(Core $core): void
    {
        (new Blocks())->register();
    }
}
