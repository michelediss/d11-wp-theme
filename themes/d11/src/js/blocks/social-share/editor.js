const { blocks, blockEditor, element, i18n, serverSideRender } = window.wp;

const { registerBlockType } = blocks;
const { useBlockProps } = blockEditor;
const { createElement } = element;
const { __ } = i18n;
const ServerSideRender = serverSideRender;

registerBlockType('custom/social-share', {
  title: __('Social Share', 'd11'),
  description: __('Social sharing buttons for the current content.', 'd11'),
  category: 'widgets',
  icon: 'share',
  edit() {
    return createElement(
      'div',
      useBlockProps(),
      createElement(ServerSideRender, {
        block: 'custom/social-share',
      })
    );
  },
  save() {
    return null;
  },
});
