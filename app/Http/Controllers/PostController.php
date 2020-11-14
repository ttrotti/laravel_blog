<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Session;
use App\Category;
use App\Tag;
use App\Comment;
use Purifier;
use Image;
use Storage;
use File;

class PostController extends Controller
{
    // usamos middleware para que solo quienes se hayan logueado puedan acceder a este controlador
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable and store all the blog post in it from the database

        $categories = Category::all();
        $posts = Post::orderBy('id', 'desc')->paginate(10);

        // return a view and pass in the above variable

        return view('posts.index')->withPosts($posts)->withCategories($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, array(
            //validation rules
            'title' => 'required|max:255',
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id' => 'required|integer', 
            'body' => 'required',
            'featured_image' => 'sometimes|image',
        ));

        // store in the database
        // esto sucede unicamente si se cumple la validación 
        $post = new Post;

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

        //save the image
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(1280, 720, function($c) {
                $c->aspectRatio();
            })->save($location);

            $post->image = $filename;
        }
        
        $post->save();

        $post->tags()->sync($request->tags, false);

        //Session::flash('key', 'value');

        Session::flash('success', 'The blog post was successfuly saved!');

        // redirect to another page
        
        return redirect()->route('posts.show', $post->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find the post in the database and save it as a variable

        $post = Post::find($id);
        $tags = Tag::pluck('name', 'id');
        $categories = Category::pluck('name','id');

        // return the view and pass in the var we previously created

        return view('posts.edit')->withPost($post)->withCategories($categories)->withTags($tags);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate the data

        $this->validate($request, array(
            //validation rules
            'title' => 'required|max:255',
            "slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug,$id",
            'body' => 'required',
            'category_id' => 'required|integer',
            'featured_image' => 'image'
        ));


        // store in the database
        // esto sucede unicamente si se cumple la validación 
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->body = Purifier::clean($request->input('body'));
        $post->category_id = $request->input('category_id'); 

        if ($request->hasFile('featured_image')) {
            $oldFilename = $post->image;
            // add the new photo
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(1280, 720, function($c) {
                $c->aspectRatio();
            })->save($location);

            // update the database
            $post->image = $filename;

            // delete the old photo
            File::delete(public_path('images/'. $oldFilename));
        }

        $post->save();

        $post->tags()->sync($request->tags, true);

        //Session::flash('key', 'value');

        Session::flash('success', 'The blog post was successfuly saved!');

        // redirect to another page
        
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();
        //esto borra las líneas de la DB post_tag donde se referencia al ID del post borrado 
        //por ej: borro el post 9, laravel entonces revisa la tabla post_tag y elimina todas las rows donde es mencionado
        File::delete(public_path('images/'. $post->image));
        $post->delete();

        Session::flash('success', 'The post was successfully deleted.');

        return redirect()->route('posts.index');
    }
}
