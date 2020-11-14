@extends('main')

@section('title', '| All Tags')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <h1>Tags</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th class="text-center"> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <th> {{ $tag->id }} </th>
                            <td> <a href="{{ route('tags.show', $tag->id)}} "> {{ $tag->name }} </a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div> <!-- end of col-md-8 -->

        <div class="col-md-3 col-md-offset-1">
            <div class="well">
                <h3>New Tag</h3>
                <form method="POST" action="{{ route('tags.store') }}" data-parsley-validate>
                    <div class="form-group">
                        <label name="name">Name:</label>
                        <input id="name" name="name" class="form-control" required maxlength="255">
                    </div>
                
                        <input type="submit" value="Create" class="btn btn-success btn-lg btn-block">
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                 </form>
            </div>
        </div>

    </div>


@endsection