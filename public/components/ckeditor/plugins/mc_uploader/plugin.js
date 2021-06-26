CKEDITOR.plugins.add( 'mc_uploader', {
    init: function( editor ) {
        editor.config.filebrowserBrowseUrl = '/public/components/ckeditor/plugins/mc_uploader/uploader.php';
    }
});

