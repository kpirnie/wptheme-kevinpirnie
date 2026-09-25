( function( blocks, element, blockEditor, components, data, serverSideRender ) {
    
    const el = element.createElement;
    const { registerBlockType } = blocks;
    const { SelectControl, Placeholder, Spinner } = components;
    const { useSelect } = data;
    const { useBlockProps } = blockEditor;
    const ServerSideRender = serverSideRender;

    registerBlockType( 'kpt/cta-block', {
        
        edit: function( props ) {
            
            const { attributes, setAttributes } = props;
            const blockProps = useBlockProps();

            const ctas = useSelect( ( select ) => {
                return select( 'core' ).getEntityRecords( 'postType', 'kpt_cta', {
                    per_page: -1,
                    status: 'publish'
                } );
            }, [] );

            const ctaOptions = ctas ? [
                { value: 0, label: 'Select a CTA...' },
                ...ctas.map( cta => ( {
                    value: cta.id,
                    label: cta.title.rendered
                } ) )
            ] : [ { value: 0, label: 'Loading...' } ];

            return el(
                'div',
                blockProps,
                el(
                    'div',
                    { 
                        style: { 
                            marginBottom: '20px',
                            padding: '15px',
                            background: '#fff',
                            border: '1px solid #ddd',
                            borderRadius: '4px'
                        }
                    },
                    el( SelectControl, {
                        label: 'Select CTA',
                        value: attributes.ctaId,
                        options: ctaOptions,
                        onChange: ( value ) => setAttributes( { ctaId: parseInt( value ) } ),
                        help: 'Choose which Call To Action to display'
                    } )
                ),
                attributes.ctaId > 0 ? el(
                    ServerSideRender,
                    {
                        block: 'kpt/cta-block',
                        attributes: attributes
                    }
                ) : el(
                    Placeholder,
                    {
                        icon: 'megaphone',
                        label: 'CTA Display'
                    },
                    el( 'p', null, 'Select a CTA from the dropdown above to preview it here.' )
                )
            );
            
        },

        save: function() {
            return null;
        }
        
    } );

} )( 
    window.wp.blocks, 
    window.wp.element, 
    window.wp.blockEditor, 
    window.wp.components, 
    window.wp.data,
    window.wp.serverSideRender 
);