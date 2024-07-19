@extends('layouts.backend')

@section('content-header')
    <div class="page-header">
        <h3 class="page-title">
          Tambah Portofolio
        </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">Administrator</li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ url('administrator/portofolio') }}">Portofolio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Portofolio</li>
          </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['url' => route('portofolio.store'),
                  'method' => 'post', 'files'=>true, 'class'=>'form-sample']) !!}
                    @include('backend.protofolio.form._form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
  <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
  <script type="text/javascript">
    tinymce.init({
      selector: "textarea",theme: "modern",
      plugins: [
           "advlist autolink link image lists charmap print preview hr anchor pagebreak",
           "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
           "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
     ],
     toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
     toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
     image_advtab: true ,
     
     external_filemanager_path:"{{url('/')}}/library/rm/filemanager/",
     filemanager_title:"Responsive Filemanager" ,
     external_plugins: { "filemanager" : "{{url('/')}}/library/rm/tinymce/plugins/responsivefilemanager/plugin.min.js"}
   });
    $("#review").rating();
  </script>
@endsection