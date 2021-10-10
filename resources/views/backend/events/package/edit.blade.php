@extends('layouts.backend')

@section('content-header')
    <div class="page-header">
        <h3 class="page-title">
          Edit Events
        </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">Administrator</li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ url('administrator/events') }}">Events</a></li>
            {{-- <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></li> --}}
            <li class="breadcrumb-item active" aria-current="page">Edit Events</li>
          </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {!! Form::model($package, ['url' => route('events.update', $package->id),
                  'method'=>'put', 'files'=>true, 'class'=>'form-sample']) !!}
                  @include('backend.events.package.form._form')
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
     
     external_filemanager_path:"/responsive_filemanager/filemanager/",
     filemanager_title:"Responsive Filemanager" ,
     external_plugins: { "filemanager" : "/responsive_filemanager/tinymce/plugins/responsivefilemanager/plugin.min.js"}
   });
  </script>
@endsection
