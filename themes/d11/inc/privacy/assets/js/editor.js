(function (wp) {
  const { __ } = wp.i18n;
  const { registerBlockType } = wp.blocks;
  const { InspectorControls } = wp.blockEditor;
  const { PanelBody, SelectControl, ToggleControl } = wp.components;
  const { Fragment, createElement: el } = wp.element;
  const ServerSideRender = wp.serverSideRender;

  registerBlockType("d11/privacy-banner", {
    title: __("Cookie Banner", "d11"),
    icon: "shield",
    category: "widgets",
    edit: function () {
      return el(ServerSideRender, {
        block: "d11/privacy-banner"
      });
    },
    save: function () {
      return null;
    }
  });

  registerBlockType("d11/privacy-cookie-table", {
    title: __("Cookie Table", "d11"),
    icon: "table-col-after",
    category: "widgets",
    edit: function (props) {
      const attributes = props.attributes;
      const setAttributes = props.setAttributes;

      return el(
        Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            {
              title: __("Cookie table settings", "d11"),
              initialOpen: true
            },
            el(SelectControl, {
              label: __("Layout", "d11"),
              value: attributes.layout || "table",
              options: [
                { label: __("Table", "d11"), value: "table" },
                { label: __("Cards", "d11"), value: "cards" }
              ],
              onChange: function (value) {
                setAttributes({ layout: value });
              }
            }),
            el(SelectControl, {
              label: __("Category filter", "d11"),
              value: attributes.category || "",
              options: [
                { label: __("All categories", "d11"), value: "" },
                { label: __("Necessary", "d11"), value: "functional" },
                { label: __("Preferences", "d11"), value: "preferences" },
                { label: __("Anonymous analytics", "d11"), value: "statistics-anonymous" },
                { label: __("Analytics", "d11"), value: "statistics" },
                { label: __("Marketing", "d11"), value: "marketing" }
              ],
              onChange: function (value) {
                setAttributes({ category: value });
              }
            }),
            el(ToggleControl, {
              label: __("Show category column", "d11"),
              checked: attributes.showCategory !== false,
              onChange: function (value) {
                setAttributes({ showCategory: value });
              }
            }),
            el(ToggleControl, {
              label: __("Show duration column", "d11"),
              checked: attributes.showDuration !== false,
              onChange: function (value) {
                setAttributes({ showDuration: value });
              }
            })
          )
        ),
        el(ServerSideRender, {
          block: "d11/privacy-cookie-table",
          attributes: attributes
        })
      );
    },
    save: function () {
      return null;
    }
  });
})(window.wp);
