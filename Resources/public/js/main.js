require.config({
    paths: {
        baseapplication: '../../baseapplication/js'
    }
});

define(function() {
    'use strict';
    return {
        name: "Base Application Bundle",
        initialize: function(app) {
            let ckeditor = app.sandbox.ckeditor,
                toolbar = ckeditor.getToolbar();

            ckeditor.addPlugin('colorbutton');
            ckeditor.addPlugin('image2');
            ckeditor.addPlugin('selectall');
            ckeditor.addPlugin('find');
            ckeditor.addPlugin('font');
            ckeditor.addPlugin('clipboard');

            toolbar.basicstyles = ['FontSize', ...toolbar.basicstyles, 'TextColor', 'BGColor', 'Smiley'];
            toolbar.insert = [...toolbar.insert, 'Image', 'HorizontalRule', 'MagicLine'];
            toolbar.semantics.push('Styles');
            toolbar.paste.push('PasteText');
            toolbar.edition = [ 'Find', 'Replace', 'SelectAll', 'RemoveFormat', 'Undo', 'Redo' ];
            toolbar.paragraph = ['Blockquote'];
            toolbar.view = ['Maximize'];

            ckeditor.setToolbar({...toolbar});
        }
    };
});
