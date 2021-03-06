/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.dialog.add( 'anchor', function( editor ) {
    // Function called in onShow to load selected element.
    var loadElements = function( element ) {
            this._.selectedElement = element;

            var attributeValue = element.data( 'cke-saved-name' );
            this.setValueOf( 'info', 'txtName', attributeValue || '' );
        };

    function createFakeAnchor( editor, anchor ) {
        return editor.createFakeElement( anchor, 'cke_anchor', 'anchor' );
    }

    return {
        title: editor.lang.wblink.anchor.title,
        minWidth: 300,
        minHeight: 60,
        onOk: function() {
            var name = CKEDITOR.tools.trim( this.getValueOf( 'info', 'txtName' ) );
            var attributes = {
                id: name,
                name: name,
                'data-cke-saved-name': name
            };

            if ( this._.selectedElement ) {
                if ( this._.selectedElement.data( 'cke-realelement' ) ) {
                    var newFake = createFakeAnchor( editor, editor.document.createElement( 'a', { attributes: attributes } ) );
                    newFake.replace( this._.selectedElement );
                } else
                    this._.selectedElement.setAttributes( attributes );
            } else {
                var sel = editor.getSelection(),
                    range = sel && sel.getRanges()[ 0 ];

                // Empty anchor
                if ( range.collapsed ) {
                    if ( CKEDITOR.plugins.wblink.synAnchorSelector )
                        attributes[ 'class' ] = 'cke_anchor_empty';

                    if ( CKEDITOR.plugins.wblink.emptyAnchorFix ) {
                        attributes[ 'contenteditable' ] = 'false';
                        attributes[ 'data-cke-editable' ] = 1;
                    }

                    var anchor = editor.document.createElement( 'a', { attributes: attributes } );

                    // Transform the anchor into a fake element for browsers that need it.
                    if ( CKEDITOR.plugins.wblink.fakeAnchor )
                        anchor = createFakeAnchor( editor, anchor );

                    range.insertNode( anchor );
                } else {
                    if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
                        attributes[ 'class' ] = 'cke_anchor';

                    // Apply style.
                    var style = new CKEDITOR.style({ element: 'a', attributes: attributes } );
                    style.type = CKEDITOR.STYLE_INLINE;
                    editor.applyStyle( style );
                }
            }
        },

        onHide: function() {
            delete this._.selectedElement;
        },

        onShow: function() {
            var selection = editor.getSelection(),
                fullySelected = selection.getSelectedElement(),
                partialSelected;

            // Detect the anchor under selection.
            if ( fullySelected ) {
                if ( CKEDITOR.plugins.wblink.fakeAnchor ) {
                    var realElement = CKEDITOR.plugins.wblink.tryRestoreFakeAnchor( editor, fullySelected );
                    realElement && loadElements.call( this, realElement );
                    this._.selectedElement = fullySelected;
                } else if ( fullySelected.is( 'a' ) && fullySelected.hasAttribute( 'id' ) ){
                    loadElements.call( this, fullySelected );
                    }
            } else {
                partialSelected = CKEDITOR.plugins.wblink.getSelectedLink( editor );
                if ( partialSelected ) {
                    loadElements.call( this, partialSelected );
                    selection.selectElement( partialSelected );
                }
            }
            this.getContentElement( 'info', 'txtName' ).focus();
        },
        contents: [
            {
            id: 'info',
            label: editor.lang.wblink.anchor.title,
            accessKey: 'I',
            elements: [
                {
                type: 'text',
                id: 'txtName',
                label: editor.lang.wblink.anchor.id,
                required: true,
                validate: function() {
                    if ( !this.getValue() ) {
                        alert( editor.lang.wblink.anchor.errorName );
                        return false;
                    }
                    return true;
                }
            }
            ]
        }
        ]
    };
});
