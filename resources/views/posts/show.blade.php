@extends('main')

@section('title', '| View Post')

@section('content')

<div class="row">

    <div class="col-md-8">
        <img src=" {{ asset('images/'. $post->image) }} " style="width:100%;">

        <h1> {{ $post->title }} </h1>

        <p>{!! $post->body !!}</p>

        <hr>

        <div class="tags">
            @foreach ($post->tags as $tag)
                <span class="label label-default">
                    <a style="color:white;" href="{{ route('tags.show', $tag->id)}}"> {{ $tag->name }} </a>
                </span>
            @endforeach
        </div>

        <div id="backend-comments" style="margin-top: 50px;">
        <h3>Comments <small> {{ $post->comments()->count()}} in total </h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Comment</th>
                        <th width="70px"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($post->comments as $comment)   
                    <tr>
                        <td> {{ $comment->name }} </td>
                        <td> {{ $comment->email }} </td>
                        <td> {{ $comment->comment }} </td>
                        <td>
                            <a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-xs btn-danger"><span class ="glyphicon glyphicon-trash"></span> </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="col-md-4">
        <dl class="well">

            <!-- hacer url("blog/{slug}") o route("route", {slug}) es lo mismo -->
            <dl class="dl-vertical">
                <dt>URL:</dt>
                <dd><a href=" {{ url("/blog/$post->slug") }} ">{{ route('blog.single', $post->slug) }}</a></dd>
            </dl>

            <dl class="dl-vertical">
                <dt>Category:</dt>
             <dd>{{$post->category->name}}</dd>
            </dl>
           
            <dl class="dl-vertical">
                <dt>Created At:</dt>
                <dd>{{ date( 'j M H:i', strtotime($post->created_at)) }}</dd>
            </dl>

            <dl class="dl-vertical">
                <dt>Last Updated:</dt>
                <dd>{{ date( 'j M H:i', strtotime($post->updated_at)) }}</dd>
            </dl>

            <hr>

            <div class="row">
                <div class="col-sm-6">
                    {!! Html::linkRoute('posts.edit', 'Edit', array($post->id), array('class' => 'btn btn-primary btn-block')) !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'DELETE']) !!}

                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}

                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{ Html::linkRoute('posts.index', '<< See All Posts', [], ['class' => 'btn btn-default btn-block']) }}
                </div>
            </div>

        </dl>
    </div>



</div>




@endsection   