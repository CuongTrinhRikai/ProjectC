<script>
    tinymce.init({
        selector: "tinymce",height: 500,
        relative_urls : false,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| custom-filemanager | link unlink anchor | forecolor backcolor  | print preview responsiveFilemanager code ",

        // setup: function (editor) {
        //     editor.ui.registry.addButton('custom-filemanager', {
        //         icon: 'image',
        //         onAction: function (_) {
        //             $("button[title='Insert file']").click();
        //         },
        //     });
        // },
        // image_advtab: true,

        // external_filemanager_path: "/filemanager/",
        // filemanager_title: "Responsive Filemanager" ,
        // external_plugins: { "filemanager" : "/tinymce/plugins/responsivefilemanager/plugin.min.js"}
    });
</script>
