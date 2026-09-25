(function (blocks, element, blockEditor, components, serverSideRender) {

    const el = element.createElement;
    const { registerBlockType } = blocks;
    const { SelectControl, Placeholder } = components;
    const { useBlockProps, InspectorControls } = blockEditor;
    const { PanelBody } = components;

    registerBlockType('kpt/portfolio-block', {

        apiVersion: 2,
        title: 'Portfolio Slideshow',
        description: 'Display portfolio items as a slideshow',
        category: 'kpt-blocks',
        icon: 'images-alt2',
        keywords: ['portfolio', 'slideshow', 'gallery', 'projects'],
        supports: {
            anchor: true,
            align: ['wide', 'full'],
        },
        attributes: {
            featuredImageSize: {
                type: 'string',
                default: 'portfolio-featured'
            },
            gridImageSize: {
                type: 'string',
                default: 'portfolio-grid'
            }
        },

        edit: function (props) {

            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            const imageSizeOptions = [
                { value: 'portfolio-featured', label: 'Portfolio Featured (800x850)' },
                { value: 'portfolio-grid', label: 'Portfolio Grid (400x275)' },
                { value: 'hero', label: 'Hero (1920x350)' },
                { value: 'articlehead', label: 'Article Head (963x385)' },
                { value: 'articlelist', label: 'Article List (520x193)' },
                { value: 'innerpage', label: 'Inner Page (482x397)' },
                { value: 'full', label: 'Full Size' },
                { value: 'large', label: 'Large' },
                { value: 'medium_large', label: 'Medium Large' },
                { value: 'medium', label: 'Medium' },
                { value: 'thumbnail', label: 'Thumbnail' },
            ];

            return el(
                'div',
                blockProps,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: 'Image Settings', initialOpen: true },
                        el(SelectControl, {
                            label: 'Featured Image Size',
                            value: attributes.featuredImageSize,
                            options: imageSizeOptions,
                            onChange: function (value) { setAttributes({ featuredImageSize: value }); },
                            help: 'Select the image size for the large featured item'
                        }),
                        el(SelectControl, {
                            label: 'Grid Image Size',
                            value: attributes.gridImageSize,
                            options: imageSizeOptions,
                            onChange: function (value) { setAttributes({ gridImageSize: value }); },
                            help: 'Select the image size for the smaller grid items'
                        })
                    )
                ),
                el(
                    'div',
                    { className: 'kpt-portfolio-preview', style: { display: 'flex', gap: '1rem', padding: '1rem', background: '#1f2937', borderRadius: '0.5rem' } },
                    el('div', { style: { width: '50%', height: '400px', background: 'linear-gradient(135deg, #599bb8 0%, #2d7696 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'flex-end', justifyContent: 'flex-start', padding: '1rem' } },
                        el('span', { style: { color: 'white', fontSize: '14px', fontWeight: 'bold' } }, 'Featured Item')
                    ),
                    el('div', { style: { width: '50%', display: 'grid', gridTemplateColumns: 'repeat(2, 1fr)', gridTemplateRows: 'repeat(3, 1fr)', gap: '0.5rem' } },
                        el('div', { style: { background: 'linear-gradient(135deg, #43819c 0%, #1c375c 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'flex-end', padding: '0.5rem' } }, el('span', { style: { color: 'white', fontSize: '11px' } }, 'Grid 1')),
                        el('div', { style: { background: 'linear-gradient(135deg, #2d7696 0%, #000d2d 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'flex-end', padding: '0.5rem' } }, el('span', { style: { color: 'white', fontSize: '11px' } }, 'Grid 2')),
                        el('div', { style: { background: 'linear-gradient(135deg, #599bb8 0%, #2d7696 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'flex-end', padding: '0.5rem' } }, el('span', { style: { color: 'white', fontSize: '11px' } }, 'Grid 3')),
                        el('div', { style: { background: 'linear-gradient(135deg, #43819c 0%, #1c375c 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'flex-end', padding: '0.5rem' } }, el('span', { style: { color: 'white', fontSize: '11px' } }, 'Grid 4')),
                        el('div', { style: { background: 'linear-gradient(135deg, #2d7696 0%, #000d2d 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'flex-end', padding: '0.5rem' } }, el('span', { style: { color: 'white', fontSize: '11px' } }, 'Grid 5')),
                        el('div', { style: { background: 'linear-gradient(135deg, #599bb8 0%, #2d7696 100%)', borderRadius: '0.375rem', display: 'flex', alignItems: 'flex-end', padding: '0.5rem' } }, el('span', { style: { color: 'white', fontSize: '11px' } }, 'Grid 6'))
                    )
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
    window.wp.components,
    window.wp.serverSideRender
);