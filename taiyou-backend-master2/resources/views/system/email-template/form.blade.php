@extends('system.layouts.form')
@section('inputs')
<x-system.form.form-group :input="[ 'name' => 'title', 'label' => 'Title', 'required' => true, 'default' => $item->title ?? old('title'), 'error' => $errors->first('title')]" />
<x-system.form.form-group :input="[ 'name' => 'code', 'label' => 'Code', 'required' => true, 'default' => $item->code ?? old('code'),'readonly'=>true, 'error' => $errors->first('code')]" />
<x-system.form.form-group :input="[ 'name' => 'from', 'label' => 'From Email', 'required' => true, 'default' => $item->from ?? old('from'), 'error' => $errors->first('from')]" />
<ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach(globalLanguages() as $lang)
    <li class="nav-item">
        <a class="nav-link" id="tabControls{{$loop->index}}tab" data-toggle="tab" href="#tabControls{{$loop->index}}tabpane" role="tab" aria-controls="tabControls{{$loop->index}}tabpane">{{$lang->language_code}}</a>
    </li>
    @endforeach
</ul>
<div class="tab-content" id="myTabContent" style="padding-top:25px">
    @foreach(globalLanguages() as $lang)
    <div class="tab-pane fade" id="tabControls{{$loop->index}}tabpane" role="tabpanel" aria-labelledby="tabControls{{$loop->index}}tab">
        <input type="hidden" name="multilingual[{{$loop->index}}][language_code]" value="{{$lang->language_code}}">
        <x-system.form.form-group :input="['label' => 'Subject', 'required' => true,'error' => $errors->first('multilingual.'.$loop->index.'.subject')]">
            <x-slot name="inputs">
                <x-system.form.input-normal :input="['name'=>'multilingual['.$loop->index.'][subject]', 'label' => 'Subject','default' => isset($item) ? $item->getContentByLanguage($lang->language_code, 'subject') : old('multilingual['.$loop->index.'][subject]'), 'error' => $errors->first('multilingual.'.$loop->index.'.subject')]" />
            </x-slot>
        </x-system.form.form-group>
        <x-system.form.form-group :input="['label' => 'Template', 'required' => true,'error' => $errors->first('multilingual.'.$loop->index.'.template')]">
            <x-slot name="inputs">
                <x-system.form.text-area :input="['name'=>'multilingual['.$loop->index.'][template]', 'label' => 'Template', 'editor' => true,'rows'=>10, 'default' => isset($item) ? $item->getContentByLanguage($lang->language_code, 'template') : old('multilingual['.$loop->index.'][template]'), 'error' => $errors->first('multilingual.'.$loop->index.'.template')]" />
            </x-slot>
        </x-system.form.form-group>
    </div>
    @endforeach
</div>
@endsection
@section('scripts')
<script>
    const errors = `{{ array_key_first($errors->get('multilingual.*')) }}`
    if (errors.length > 0) {
        const indexes = errors.split('.')
        $('#tabControls' + indexes[1] + 'tab').tab('show')
    } else {
        $('#tabControls0tab').tab('show')
    }
</script>
<script>
    tinymce.init({
        selector: "textarea",height: 500,
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
@endsection

