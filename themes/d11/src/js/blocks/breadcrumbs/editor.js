const { blocks, blockEditor, components, element, i18n, serverSideRender } = window.wp;

const { registerBlockType } = blocks;
const { InspectorControls, useBlockProps } = blockEditor;
const { PanelBody, TextControl, ToggleControl } = components;
const { Fragment, createElement } = element;
const { __ } = i18n;
const ServerSideRender = serverSideRender;

registerBlockType('custom/breadcrumbs', {
  title: __('Breadcrumbs', 'd11'),
  description: __('Contextual navigation trail for the current view.', 'd11'),
  category: 'widgets',
  icon: 'ellipsis',
  attributes: {
    showCurrent: {
      type: 'boolean',
      default: true,
    },
    separator: {
      type: 'string',
      default: '/',
    },
  },
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

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
          createElement(ToggleControl, {
            label: __('Show current page', 'd11'),
            checked: !!attributes.showCurrent,
            onChange(value) {
              setAttributes({ showCurrent: value });
            },
          }),
          createElement(TextControl, {
            label: __('Separator', 'd11'),
            value: attributes.separator || '/',
            onChange(value) {
              setAttributes({ separator: value || '/' });
            },
          })
        )
      ),
      createElement(
        'div',
        blockProps,
        createElement(ServerSideRender, {
          block: 'custom/breadcrumbs',
          attributes,
        })
      )
    );
  },
  save() {
    return null;
  },
});
