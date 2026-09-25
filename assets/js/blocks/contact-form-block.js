(function (blocks, element, blockEditor, serverSideRender) {

    const el = element.createElement;
    const { registerBlockType } = blocks;
    const { Placeholder } = wp.components;
    const { useBlockProps } = blockEditor;
    const ServerSideRender = serverSideRender;

    registerBlockType('kpt/contact-form-block', {

        apiVersion: 2,
        title: 'Contact Form',
        description: 'Display the contact form',
        category: 'kpt-blocks',
        icon: 'email',
        keywords: ['contact', 'form', 'email'],
        supports: {
            anchor: true,
            align: ['wide', 'full'],
        },

        edit: function (props) {

            const blockProps = useBlockProps();

            return el(
                'div',
                blockProps,
                el(
                    ServerSideRender,
                    {
                        block: 'kpt/contact-form-block',
                        attributes: props.attributes
                    }
                )
            );

        },

        save: function () {
            return null;
        }

    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.serverSideRender
);