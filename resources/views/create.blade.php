@extends('layouts.master')


@section('content')

    <div class="main-container mt-5">
        @if($errors->any() )
            @foreach($errors->all() as $error )
                <div class="alert alert-danger">{{$error}}</div>
            @endforeach
        @endif

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Create Post</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="btn-sm btn-success mx-1" href="{{route('posts.index')}}">Back</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="image" class="form-label">Image</label>
                        <input id="image" type="file" class="form-control" name="image">
                    </div>
                    <div class="form-group">
                        <label for="title" class="form-label">Title</label>
                        <input id="title" type="text" class="form-control" name="title">
                    </div>

                    <div class="form-group">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" type="text" class="form-control" name="category_id">
                            <option value=" ">Select</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" cols="30" rows="10" id="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group mt-3">
                       <button class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
