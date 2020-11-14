@extends('main')

@section('title', '| Edit Post')

@section('stylesheets')

  {!! Html::style('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css') !!}
  <script src="https://cdn.tiny.cloud/1/e5rlpz3ta4sfvyks4fppd61hejj5jn6ib7yyk506a79pe5tl/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    tinymce.init({
      selector: 'textarea'
    });
  </script>
@endsection

@section('content')

<div class="row">
    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PUT', 'files' => true]) !!}
    <div class="col-md-8">
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title', null, ["class" => 'form-control input-lg']) }}

        {{ Form::label('slug', 'Slug:') }}
        {{ Form::text('slug', null, ["class" => 'form-control']) }}

        {{ Form::label('category', 'Category:') }}
        {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
        
        {{ Form::label('tags', 'Tags:') }}
        {!! Form::select('tags[]', $tags, null, ['class' => 'form-control js-example-placeholder-multiple js-states', 'multiple' => 'multiple']) !!}

        {{ Form::label('featured_image', 'Update Featured Image:', ['class' => 'form-spacing-top']) }}
        {!! Form::file('featured_image' ) !!}
    
        {{ Form::label('body', "Body:", ['class' => 'form-spacing-top']) }}
        {{ Form::textarea('body', null, ['class' => 'form-control']) }}
    </div>
    
    
    <div class="col-md-4">
        
        <div class="well">
            <dl class="dl-horizontal">
                <dt>Created At:</dt>
                <dd>{{ date('j M H:i', strtotime($post->created_at)) }}</dd>
            </dl>
    
            <dl class="dl-horizontal">
            <dt>Last Updated:</dt>
            <dd>{{ date('j M H:i', strtotime($post->updated_at)) }}</dd>
            </dl>

            <hr>

            <div class="row">

                <div class="col-sm-6">
                    {!! Html::linkRoute('posts.show', 'Cancel', array($post->id), array('class' => 'btn btn-danger btn-block')) !!}
                </div>

                <div class="col-sm-6">
                    {{  Form::submit('Save Changes', ['class' => 'btn btn-success btn-block'])  }}
                </div>

            </div>
        </div> <!-- well -->
    </div>
  {!! Form::close() !!}

</div> <!-- end of .row (form) -->

@section('scripts')
  {!! Html::script('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js') !!}

    <script>
        $(".js-example-placeholder-multiple").select2({
        placeholder: "Select your tags"
        });   
    </script>
@endsection


@endsection   