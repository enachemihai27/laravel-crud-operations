@extends('layouts.master')


@section('content')

    <div class="main-container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Show post</h4>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="btn-sm btn-success mx-1" href="{{route('posts.index')}}">Back</a>
                        @can('create_post')
                            <a class="btn-sm btn-success mx-1" href="{{route('posts.create')}}">Create</a>
                            <a class="btn-sm btn-warning mx-1" href="{{route('posts.trashed')}}">Trashed</a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered bordered-drk">
                    <tbody>
                        {{--<tr>
                            <th scope="row">{{$post->id}}</th>
                            <td>
                                <img src="{{asset($post->image)}}" alt="" width="80">
                            </td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->description}}</td>
                            <td>{{$post->category_id}}</td>
                            <td>{{date('d-m-y', strtotime($post->created_at))}}</td>
                            <td>
                                <a class="btn-sm btn-success" href="{{route('posts.show', $post->id)}}">Show</a>
                                <a class="btn-sm btn-primary" href="{{route('posts.edit', $post->id)}}">Edit</a>

                                <form method="POST" action="{{route('posts.destroy', $post->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>--}}
                        <tr>
                            <td>Id</td>
                            <td>{{$post->id}}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td><img width="300" height="300" src="{{asset($post->image)}}" alt=""></td>
                        </tr>
                        <tr>
                            <td>Title</td>
                            <td>{{$post->title}}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{{$post->description}}</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>{{$post->category_id}}</td>
                        </tr>
                        <tr>
                            <td>Publish date</td>
                            <td>{{date('d-m-Y', strtotime($post->created_at))}}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
