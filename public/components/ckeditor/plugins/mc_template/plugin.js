CKEDITOR.plugins.add( 'mc_template', {
    lang:"de,en,fr",
    init: function( editor ) {
        editor.addCommand( 'insertTemplate', {
            exec: function( editor ) {
                viewModal('modal', '/templates/all');
            }
        });
        editor.ui.addButton( 'Insert Template', {
            label: editor.lang.mc_template.toolbar,
            command: 'insertTemplate',
            toolbar: 'insert,1',
            icon: 'plugins/mc_template/icons/insert_template.jpg'
        });
    }
});