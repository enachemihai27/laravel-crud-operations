<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*        //store data in case for 60 sec
                $posts = Cache::remember('posts-page-'.request('page', 1), 60*3, function () {
                    return Post::with('category')->paginate(5);
                });*/

        //store data in cache forever
        /*        $posts = Cache::rememberForever('posts', function () {
                    return Post::with('category')->paginate(5);
                });*/

        $posts = Post::orderBy('id', 'desc')->paginate(5);

        return view('index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create()
    {

        $this->authorize('create', Post::class);

        $categories = Category::all();
        return view('create', compact('categories'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        //validate request
        $request->validate([
            'image' => ['required', 'max:2028', 'image'],
            'title' => ['required', 'max:255'],
            'category_id' => ['required', 'integer'],
            'description' => ['required']
        ]);

        //store image
        $fileName = time() . '_' . $request->image->getClientOriginalName();
        $filePath = $request->image->storeAs('uploads', $fileName, 'public');

        //create post and save
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category_id = $request->category_id;
        $post->image = 'storage/' . $filePath;
        $post->save();

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);

        return view('show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(string $id)
    {

        $post = Post::findOrFail($id);

        $this->authorize('update', $post);

        $categories = Category::all();
        return view('edit', compact('post', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('update', $post);
        //validate request
        $request->validate([
            'title' => ['required', 'max:255'],
            'category_id' => ['required', 'integer'],
            'description' => ['required']
        ]);


        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['required', 'max:2028', 'image']
            ]);

            //store image
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $filePath = $request->image->storeAs('uploads', $fileName, 'public');

            File::delete(public_path($post->image));

            $post->image = 'storage/' . $filePath;
        }


        $post->title = $request->title;
        $post->description = $request->description;
        $post->category_id = $request->category_id;


        $post->save();

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index');

    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()->get();
        return view('trashed', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.trashed');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        File::delete(public_path($post->image));
        $post->forceDelete();

        return redirect()->route('posts.trashed');
    }
}
