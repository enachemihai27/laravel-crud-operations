@extends('layouts.master')


@section('content')

    <div class="main-container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Trashed Posts</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="btn-sm btn-success mx-1" href="{{route('posts.create')}}">Create</a>
                        <a class="btn-sm btn-success mx-1" href="{{route('posts.index')}}">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered bordered-drk">
                    <thead style="background: #f2f2f2">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="width: 10%">Image</th>
                        <th scope="col" style="width: 20%">Title</th>
                        <th scope="col" style="width: 30%">Description</th>
                        <th scope="col" style="width: 10%">Category</th>
                        <th scope="col" style="width: 10%">Publish date</th>
                        <th scope="col" style="width: 20%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <th scope="row">{{$post->id}}</th>
                            <td>
                                <img src="{{asset($post->image)}}" alt="" width="80">
                            </td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->description}}</td>
                            <td>{{$post->category->name}}</td>
                            <td>{{date('d-m-y', strtotime($post->created_at))}}</td>
                            <td>
                                <div class="d-flex" >
                                    <a class="btn-sm btn-success mx-2" href="{{route('posts.restore', $post->id)}}">Restore</a>
                                    <form method="POST" action="{{route('posts.force_delete', $post->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-sm btn-danger">Delete</button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
