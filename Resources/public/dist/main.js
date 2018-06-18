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
            app.sandbox.ckeditor.addPlugin('colorbutton');
            app.sandbox.ckeditor.addToolbarButton('colors', 'TextColor', 'cog');
            app.sandbox.ckeditor.addToolbarButton('colors', 'BGColor', 'cogs');
            // app.sandbox.ckeditor.addToolbarButton('insert', 'Image', 'picture-o');
            app.sandbox.ckeditor.addToolbarButton('insert', 'HorizontalRule', 'arrows-h');
            app.sandbox.ckeditor.addToolbarButton('semantics', 'Styles', 'css3');
            app.sandbox.ckeditor.addToolbarButton('basicstyles', 'RemoveFormat', 'filter');
            app.sandbox.ckeditor.addToolbarButton('paste', 'PasteText', 'file-text');
            app.sandbox.ckeditor.addToolbarButton('paragraph', 'Blockquote', 'quote-right');
        }
    };
});
