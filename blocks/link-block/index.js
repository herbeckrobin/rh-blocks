/**
 * Link-Block (buildless): wie core/group, nur komplett verlinkt.
 *
 * Gleiche Style-Supports wie die Gruppe (aus block.json). Link-UX wie beim Button:
 * Link-Icon in der Toolbar öffnet das native WP-Link-Popover (LinkControl), dasselbe
 * Feld im Inspector. Dynamischer Block: save gibt die Inner-Blocks aus, render.php
 * macht den a-Wrapper bzw. Stretched-Link. Transforms in beide Richtungen zu core/group.
 *
 * registerBlockType bekommt die block.json-Metadaten (window.rhLinkBlockMeta), damit
 * Attribute/Supports nicht doppelt gepflegt werden. Nutzt window.wp.* (kein Build).
 */
(function (wp, metadata) {
	'use strict';

	if (!wp || !wp.blocks || !wp.blockEditor || !wp.element || !wp.components) {
		return;
	}

	var registerBlockType = wp.blocks.registerBlockType;
	var createBlock = wp.blocks.createBlock;
	var el = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var useState = wp.element.useState;
	var __ = (wp.i18n && wp.i18n.__) ? wp.i18n.__ : function (s) { return s; };

	var be = wp.blockEditor;
	var useBlockProps = be.useBlockProps;
	var useInnerBlocksProps = be.useInnerBlocksProps;
	var InnerBlocks = be.InnerBlocks;
	var InspectorControls = be.InspectorControls;
	var BlockControls = be.BlockControls;
	var URLInput = be.URLInput;
	var LinkControl = be.__experimentalLinkControl;

	var cmp = wp.components;
	var PanelBody = cmp.PanelBody;
	var ToolbarButton = cmp.ToolbarButton;
	var Popover = cmp.Popover;
	var BaseControl = cmp.BaseControl;
	var ToggleControl = cmp.ToggleControl;
	var Button = cmp.Button;

	var blockSpec = (metadata && metadata.name) ? metadata : 'rh/link-block';

	registerBlockType(blockSpec, {
		edit: function (props) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;
			var url = attributes.url || '';

			var editingState = useState(false);
			var isEditingURL = editingState[0];
			var setIsEditingURL = editingState[1];

			var anchorState = useState(null);
			var popoverAnchor = anchorState[0];
			var setPopoverAnchor = anchorState[1];

			var blockProps = useBlockProps({ ref: setPopoverAnchor });
			var innerProps = useInnerBlocksProps(blockProps, { templateLock: false });

			var linkValue = { url: url, opensInNewTab: !!attributes.opensInNewTab };

			function onChangeLink(v) {
				setAttributes({ url: (v && v.url) || '', opensInNewTab: !!(v && v.opensInNewTab) });
			}
			function onRemoveLink() {
				setAttributes({ url: '', opensInNewTab: false });
				setIsEditingURL(false);
			}

			var toolbar = el(
				BlockControls,
				{ group: 'block' },
				el(ToolbarButton, {
					icon: 'admin-links',
					title: url ? __('Link bearbeiten', 'rh-blocks') : __('Link', 'rh-blocks'),
					isActive: !!url || isEditingURL,
					onClick: function () { setIsEditingURL(true); }
				})
			);

			var popover = isEditingURL && LinkControl
				? el(
					Popover,
					{ anchor: popoverAnchor, placement: 'bottom', shift: true, focusOnMount: 'firstElement', onClose: function () { setIsEditingURL(false); } },
					el(LinkControl, { value: linkValue, onChange: onChangeLink, onRemove: onRemoveLink, forceIsEditingLink: !url })
				)
				: null;

			var panel = el(
				InspectorControls,
				null,
				el(
					PanelBody,
					{ title: __('Link', 'rh-blocks'), initialOpen: true },
					el(
						BaseControl,
						{
							label: __('Link-Ziel', 'rh-blocks'),
							help: !url
								? __('Ohne Link verhält sich der Block wie eine normale Gruppe.', 'rh-blocks')
								: __('Die gesamte Fläche wird verlinkt. Innere Links/Buttons bleiben klickbar.', 'rh-blocks')
						},
						el(URLInput, { value: url, onChange: function (v) { setAttributes({ url: v || '' }); } })
					),
					el(ToggleControl, {
						label: __('In neuem Tab öffnen', 'rh-blocks'),
						checked: !!attributes.opensInNewTab,
						onChange: function (v) { setAttributes({ opensInNewTab: !!v }); }
					}),
					url ? el(Button, { variant: 'secondary', isDestructive: true, onClick: onRemoveLink }, __('Link entfernen', 'rh-blocks')) : null
				)
			);

			return el(Fragment, null, toolbar, popover, panel, el('div', innerProps));
		},

		save: function () {
			return el(InnerBlocks.Content);
		},

		transforms: {
			from: [
				{
					type: 'block',
					blocks: ['core/group'],
					transform: function (attributes, innerBlocks) {
						return createBlock('rh/link-block', attributes, innerBlocks);
					}
				}
			],
			to: [
				{
					type: 'block',
					blocks: ['core/group'],
					transform: function (attributes, innerBlocks) {
						var rest = Object.assign({}, attributes);
						delete rest.url;
						delete rest.opensInNewTab;
						return createBlock('core/group', rest, innerBlocks);
					}
				}
			]
		}
	});
})(window.wp, window.rhLinkBlockMeta);
