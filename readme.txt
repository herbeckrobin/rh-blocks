=== RH Blocks ===
Contributors: robinherbeck
Tags: blocks, gutenberg, link, card, clickable
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A small library of reusable custom blocks. Starts with the Link Block: a group/card whose whole area is clickable while inner links keep working.

== Description ==

RH Blocks groups reusable custom blocks under their own category. The first block is the Link Block: like a core group, but the whole surface is a link. It has the same style supports as a group (layout, colours, spacing, border, shadow, typography, sticky) and the same link UX as a button (link popover in the toolbar plus an inspector field).

Frontend renders accessibly (Adrian Roselli / Bootstrap stretched-link pattern): content without inner links makes the wrapper itself the link; content with inner links uses a stretched overlay link (aria-hidden, inner links stay clickable via z-index), never an <a> inside an <a>. Lossless transforms to and from core/group.

Buildless: registered via block.json server-side, edited via window.wp.* in the editor.

Part of the rh-blueprint collection.

== Changelog ==

= 0.1.0 =
* Initial release: Link Block (clickable group/card) with accessible stretched-link rendering and core/group transforms.
