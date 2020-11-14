@extends('layouts.app')

<!-- 

LAS QUOTES DOBLES INTERPOLAN (INTERPOLATION), ES DECIR, PUEDEN ACCEDER AL CONTENIDO DE UNA VARIABLE

ESTO ES DATA DE PHP 

-->

<?php $titleTag = htmlspecialchars($post->title); ?>

@section('title', "| $titleTag")

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <img src=" {{ asset('images/' . $post->image)}} " style="max-height:400px;display:block;margin-left:auto;margin-right:auto;">
            <h1>{{$post->title}}</h1>
            <p> {!!$post->body!!} </p>
            <hr>
            <p>Posted In: {{ $post->category['name'] }}</p>
            <div class="tags">
                <p>Tags:
                @foreach ($post->tags as $tag)
                    <span class="label label-default">
                        {{$tag->name}}
                    </span>
                @endforeach
                </p>
            </div>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <h3 class="comments-title"><span class="glyphicon glyphicon-comment"></span> {{ $post->comments()->count() }} Comments</h3>
            @foreach($post->comments as $comment)
                <div class="comment">

                    <div class="author-info">
                        <img src=" {{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?s=50&d=mm" }} " class="author-image">
                        
                        <div class="author-name">
                            <h4>{{$comment->name}}</h4>

                            <p class="author-time">{{ date('nS F, Y - G:i', strtotime($comment->created_at))}}</p>
                        </div>
                    </div>


                    <div class="comment-content">
                        {{$comment->comment}}
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div id="comment-form" class="col-md-8 col-md-offset-2">
            {!! Form::open(['route' => ['comments.store', $post->id], 'method' => 'POST']) !!}
            <div class="row">
                <div class="col-md-6">
                    {!! Form::label('name', "Name:", ['class' => 'btn-h1-spacing'])!!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::label('email', 'Email:', ['class' => 'btn-h1-spacing'])!!}
                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-md-12">
                    {!! Form::label('comment', 'Comment:', ['class' => 'btn-h1-spacing']) !!}
                    {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) !!}

                    {!! Form::submit('Add Comment', ['class' => 'btn btn-block btn-success btn-h1-spacing']) !!}
                </div>
            </div>
        </div>


    </div>

@endsection

