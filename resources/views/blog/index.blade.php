@extends('layouts.app')

@section('title', '| Blog')

@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2 text-center">
            <h1>Blog</h1>
        </div>

    </div>

    @foreach ($posts as $post)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h3> {{$post->title}} </h3>
                <h5> {{ date('j M Y', strtotime($post->created_at)) }} </h5>

                <p> {{ substr(strip_tags($post->body), 0, 250)}} {{ strlen(strip_tags($post->body)) > 250 ? "..." : "" }}  </p>

                <a href="{{ route('blog.single', $post->slug) }}" class="btn btn-primary">Read More</a>

                <hr>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

@endsection