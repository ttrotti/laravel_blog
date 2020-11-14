@extends('main')

@section('title', '| Create New Post')

@section('stylesheets')

  {!! Html::style('css/parsley.css') !!}
  {!! Html::style('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css') !!}
  <script src="https://cdn.tiny.cloud/1/e5rlpz3ta4sfvyks4fppd61hejj5jn6ib7yyk506a79pe5tl/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    tinymce.init({
      selector: 'textarea'
    }

    )
  </script>

@endsection
    
@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h1>Create New Post</h1>
      <hr>
      <form method="POST" enctype='multipart/form-data' action="{{ route('posts.store') }}" data-parsley-validate>
        <div class="form-group">
          <label name="title">Title:</label>
          <input id="title" name="title" class="form-control" required maxlength="255">
        </div>

        <div class="form-group">
          <label for="slug">Slug:</label>
          <input type="text" name="slug" class="form-control" required minlength="5" maxlength="255">
        </div>

        <div class="form-group">
          <label for="category_id">Category:</label>
          <select name="category_id" class="form-control">
          @foreach ($categories as $category)
            <option value=" {!! $category->id !!} ">
            {{ $category->name }}</option>
          @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="tags">Tags:</label>
          <select name="tags[]" class="form-control js-example-placeholder-multiple js-states form-control" multiple="multiple">
          @foreach ($tags as $tag)
            <option value=" {!! $tag->id !!} ">
            {{ $tag->name }}</option>
          @endforeach
          </select>
        </div>

        <div class="form-group">
          <label name="featured_image">Upload Featured Image:</label>
          {{ Form::file('featured_image') }}
        </div>

        <div class="form-group">
          <label name="body">Post Body:</label>
          <textarea id="body" name="body" rows="10" class="form-control"></textarea>
        </div>
        
        <input type="submit" value="Create Post" class="btn btn-success btn-lg btn-block">
        <input type="hidden" name="_token" value="{{ Session::token() }}">
      </form>
    </div>
</div>

@endsection

@section('scripts')
  {!! Html::script('js/parsley.min.js') !!}
  {!! Html::script('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js') !!}

  <script>
    $(".js-example-placeholder-multiple").select2({
    placeholder: "Select your tags"
    });   
  </script>
@endsection