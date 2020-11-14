@extends('main')

@section('title', "| Edit Tag")
    
@section('content')

{{Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' => "PUT"])}}
    <div class="form-group">
        
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    {!! Form::submit('Save Changes', ['class' => 'btn btn-success btn-spacing-top']) !!}
        
    </div>
{{ Form::close() }}

@endsection