# RH Blocks

Bibliothek wiederkehrender Custom Blocks. Teil der rh-blueprint Kollektion.

Sammelt wiederverwendbare Blöcke unter einer eigenen Kategorie. Start: der Link-Block. Wächst um weitere Blöcke, wenn sie wiederkehren.

## Blöcke

### Link-Block (`rh/link-block`)

Wie eine Gruppe, nur die gesamte Fläche (z.B. eine Card) ist klickbar. Innere Links und Buttons funktionieren weiter.

- Gleiche Style-Supports wie `core/group` (Layout, Farben, Hintergrundbild, Spacing, Border, Radius, Schatten, Typografie, Mindesthöhe, Breit/Voll, Sticky).
- Link-UX wie beim Button: Link-Icon in der Toolbar öffnet das native Link-Popover, dasselbe Feld im Inspector, „In neuem Tab öffnen".
- **Barrierefreie Ausgabe** (anerkannte Best Practice): Inhalt ohne eigene Links macht den Wrapper selbst zum `<a>`; Inhalt mit eigenen Links nutzt einen gestreckten Overlay-Link (innere Links bleiben klickbar), nie ein `<a>` im `<a>`.
- **Verlustfreie Transforms** zu und von `core/group`: bestehende Cards lassen sich umwandeln, alle Style-Attribute bleiben erhalten. Ohne Link verhält sich der Block wie eine normale Gruppe.

## Einstellungen

Keine. Das Modul registriert die Blöcke und die Kategorie „RH Blöcke" im Inserter.

## Installation

ZIP hochladen und aktivieren. Der geteilte Core ist gebündelt.

## Voraussetzungen

WordPress 6.5+, PHP 8.1+.
