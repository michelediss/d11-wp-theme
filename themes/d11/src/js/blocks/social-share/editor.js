const { blocks, blockEditor, components, element, i18n, serverSideRender } = window.wp;

const { registerBlockType } = blocks;
const { InspectorControls, useBlockProps } = blockEditor;
const { PanelBody, SelectControl, TextControl } = components;
const { Fragment, createElement } = element;
const { __ } = i18n;
const ServerSideRender = serverSideRender;

const PRESET_VALUES = ['', 'white', 'black', 'light', 'primary', 'accent'];
const LEGACY_TO_CURRENT = {
  foreground: 'black',
  muted: 'white',
  canvas: 'light',
};

registerBlockType('custom/social-share', {
  title: __('Social Share', 'd11'),
  description: __('Social sharing buttons for the current content.', 'd11'),
  category: 'widgets',
  icon: 'share',
  attributes: {
    color: {
      type: 'string',
      default: '',
    },
  },
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const color = attributes.color || '';
    const normalizedColor = LEGACY_TO_CURRENT[color] || color;
    const isPresetColor = PRESET_VALUES.includes(normalizedColor);
    const selectedValue = isPresetColor ? normalizedColor : '__custom__';

    return createElement(
      Fragment,
      null,
      createElement(
        InspectorControls,
        null,
        createElement(
          PanelBody,
          {
            title: __('Settings', 'd11'),
            initialOpen: true,
          },
          createElement(SelectControl, {
            label: __('Color', 'd11'),
            value: selectedValue,
            options: [
              { label: __('Default', 'd11'), value: '' },
              { label: __('White', 'd11'), value: 'white' },
              { label: __('Black', 'd11'), value: 'black' },
              { label: __('Light', 'd11'), value: 'light' },
              { label: __('Primary', 'd11'), value: 'primary' },
              { label: __('Accent', 'd11'), value: 'accent' },
              { label: __('Custom hex color', 'd11'), value: '__custom__' },
            ],
            onChange(value) {
              if (value === '__custom__') {
                setAttributes({ color: !isPresetColor && color ? color : '#e5232f' });
                return;
              }

              setAttributes({ color: value });
            },
          }),
          selectedValue === '__custom__'
            ? createElement(TextControl, {
                label: __('Hex color', 'd11'),
                help: __('Use values like #b85c38 or #11223344.', 'd11'),
                value: color,
                onChange(value) {
                  setAttributes({ color: value.trim() });
                },
              })
            : null
        )
      ),
      createElement(
        'div',
        blockProps,
        createElement(ServerSideRender, {
          block: 'custom/social-share',
          attributes,
        })
      )
    );
  },
  save() {
    return null;
  },
});
