'use strict';
var images = [];
for (var i = 0; i < images_array.length; i++) {
    images[i] = images_array[i];
}
// Set up GrapesJS editor with the Newsletter plugin
var editor = grapesjs.init({
    height: '100%',
    container: '#gjs',
    fromElement: true,
    storageManager: {
        autoload: 0,
    },
    assetManager: {
        storageType: '',
        storeOnChange: true,
        storeAfterUpload: true,
        upload: '/builder/mc_builder_2/', //for temporary storage
        assets: images,
        uploadFile: function(e) {
            var files = e.dataTransfer ? e.dataTransfer.files : e.target.files;
            var formData = new FormData();
            for (var i in files) {
                formData.append('file-' + i, files[i]) //containing all the selected images from local
            }
            $.ajax({
                url: '/builder/mc_builder_2/upload_image.php',
                type: 'POST',
                data: formData,
                contentType: false,
                crossDomain: true,
                dataType: 'json',
                mimeType: "multipart/form-data",
                processData: false,
                success: function(result) {
                    var myJSON = [];
                    $.each(result['data'], function(key, value) {
                        myJSON[key] = value;
                    });
                    var images = myJSON;
                    editor.AssetManager.add(images); //adding images to asset manager of GrapesJS
                }
            });
        },
    },
    container: '#gjs',
    fromElement: true,
    plugins: ['gjs-preset-newsletter', 'gjs-plugin-ckeditor'],
    pluginsOpts: {
        'gjs-preset-newsletter': {
            modalLabelImport: 'Paste all your code here below and click import',
            modalLabelExport: 'Copy the code and use it wherever you want',
            codeViewerTheme: 'material',
            importPlaceholder: '<table class="table"><tr><td class="cell">Hello world!</td></tr></table>',
            cellStyle: {
                'font-size': '12px',
                'font-weight': 300,
                'vertical-align': 'top',
                color: 'rgb(111, 119, 125)',
                margin: 0,
                padding: 0,
            }
        }
    }
});

// images render
const am = editor.AssetManager;
am.render(images);

var mdlClass = 'gjs-mdl-dialog-sm';
var pnm = editor.Panels;
var cmdm = editor.Commands;
var md = editor.Modal;

// Clear Canvas
cmdm.add('clear-canvas', {
    run(editor, sender) {
        sender.set('active', 0);
        swal({
            title: $('#clean-canvas').data('value'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (isConfirm) {
                editor.DomComponents.clear();
                setTimeout(function() {
                    localStorage.clear()
                }, 0);
                swal.close();
            }
        });
    }
});
pnm.addButton('options', {
    id: 'clear-canvas',
    className: 'fa fa-trash icon-blank',
    command: 'clear-canvas',
    attributes: {
        'title': 'Clear All',
        'data-tooltip-pos': 'bottom',
    },
});



// Edit
var pfx = editor.getConfig().stylePrefix;
var codeViewer = editor.CodeManager.getViewer('CodeMirror').clone();
var container = document.createElement('div');
var btnEdit = document.createElement('button');

codeViewer.set({
    codeName: 'htmlmixed',
    readOnly: 0,
    theme: 'hopscotch',
    autoBeautify: true,
    autoCloseTags: true,
    autoCloseBrackets: true,
    lineWrapping: true,
    styleActiveLine: true,
    smartIndent: true,
    indentWithTabs: true
});

btnEdit.innerHTML = 'Edit';
btnEdit.className = pfx + 'btn-prim ' + pfx + 'btn-import';
btnEdit.onclick = function() {
    var code = codeViewer.editor.getValue();
    editor.DomComponents.getWrapper().set('content', '');
    editor.setComponents(code.trim());
    md.close();
};
cmdm.add('html-edit', {
    run: function(editor, sender) {
        sender && sender.set('active', 0);
        var viewer = codeViewer.editor;
        md.setTitle('Edit code');
        if (!viewer) {
            var txtarea = document.createElement('textarea');
            container.appendChild(txtarea);
            container.appendChild(btnEdit);
            codeViewer.init(txtarea);
            viewer = codeViewer.editor;
        }
        var InnerHtml = editor.getHtml();
        var Css = editor.getCss();
        md.setContent('');
        md.setContent(container);

        codeViewer.setContent(InnerHtml + "<style>" + Css + '</style>');
        md.open();
        viewer.refresh();
    }
});

pnm.addButton('options',
    [{
        id: 'edit',
        className: 'fa fa-edit',
        command: 'html-edit',
        attributes: {
            title: 'Edit'
        }
    }]
);

// Save Data
cmdm.add('save-data', {
    run(editor, sender) {
        sender.set('active', 0);
        var cmdGetCode = cmdm.get('gjs-get-inlined-html');
        $("input.form-control").removeClass('has-error');
        var name = $('#template-name').val();
        if ($.trim(name) == '') {
            var v = $("[name='name']").closest("input.form-control");
            v.addClass('has-error');
            toastr.error($('#builder-msg-name-required').data('value'));
        } else {
            var action = $('#action').val();
            var id = $('#id').val();
            var html = cmdGetCode.run(editor);
            $.ajax({
                type: "POST",
                url: getAppURL()+"/template_save",
                data: {
                    action: action,
                    id: id,
                    name: name,
                    content: html,
                    type: 2
                },
                success: function(id) {
                    console.log(id);
                    toastr.success($('#msg-saved').data('value'));
                    $('#action').val('edit');
                    $('#id').val(id);
                }
            });
        }
    }
});
pnm.addButton('options', {
    id: 'save-data',
    className: 'fa fa-save icon-blank',
    command: 'save-data',
    attributes: {
        'title': 'Save',
        'data-tooltip-pos': 'bottom',
    },
});

// Exit Template
cmdm.add('exit', {
    run(editor, sender) {
        sender.set('active', 0);

        swal({
            title: $('#builder-mgs-cancel').data('value'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (isConfirm) {
                window.top.location.href = getAppURL()+"/templates";
            }
        });
    }
});
pnm.addButton('options', {
    id: 'exit',
    className: 'fa fa-sign-out icon-blank',
    command: 'exit',
    attributes: {
        'title': 'Exit',
        'data-tooltip-pos': 'bottom',
    },
});

$(document).ready(function() {
    // Beautify tooltips
    $('*[title]').each(function() {
        var el = $(this);
        var title = el.attr('title').trim();
        if (!title)
            return;
        el.attr('data-tooltip', el.attr('title'));
        el.attr('title', '');
    });

});
function getAppURL(){
  return window.location.protocol+'//'+window.location.hostname;
}