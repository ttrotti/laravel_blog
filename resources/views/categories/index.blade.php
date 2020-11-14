@extends('main')

@section('title', '| All Categories')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <h1>Categories</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th class="text-center"> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <th> {{ $category->id }} </th>
                            <td> {{ $category->name }} </td>
                            <td class="text-center">
                                    {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE']) !!}

                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}
                
                                    {!! Form::close() !!}  
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div> <!-- end of col-md-8 -->

        <div class="col-md-3 col-md-offset-1">
            <div class="well">
                <h3>New Category</h3>
                <form method="POST" action="{{ route('categories.store') }}" data-parsley-validate>
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