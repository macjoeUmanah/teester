$(function () {
  $('#copy-as-text').click(function() {
      var content_html = CKEDITOR.instances['content_html'].getSnapshot();
      var content = content_html.replace(/<br\s*\/?>/mg,"\n");
      var regex = /(<([^>]+)>)/ig
      var content = $.trim(content.replace(regex, ""));
      $('#content_text').val(content);
  });

  CKEDITOR.replace('content_html', {
    fullPage: true,
    allowedContent: true,
    height: 320
  });
  CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
  CKEDITOR.config.extraPlugins = 'font,find,justify,mc_uploader';
  CKEDITOR.config.language = $('html')[0].lang;
});
function CKupdate(){
  for ( instance in CKEDITOR.instances )
    CKEDITOR.instances[instance].updateElement();
}
function systemVariables(shortcode) {
  CKEDITOR.instances['content_html'].insertText(shortcode);
  $('#modal').modal('hide');
}
function customFields(shortcode) {
  CKEDITOR.instances['content_html'].insertText(shortcode);
  $('#modal').modal('hide');
}
function spinTags(shortcode) {
  CKEDITOR.instances['content_html'].insertText(shortcode);
  $('#modal').modal('hide');
}