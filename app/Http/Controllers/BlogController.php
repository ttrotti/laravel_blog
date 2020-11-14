<?php

// Esto se hizo con el comando php artisan make:controller BlogController
// acá van los MÉTODOS

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class BlogController extends Controller
{

    public function getIndex() {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        
        return view('blog.index')->withPosts($posts);
    }

    public function getSingle($slug) {
       // fetch from the DB based on slug
       // QUERY BUILDER, siempre termina en get(), first() selecciona solo el primero
       $post = Post::where('slug', '=', $slug)->first();

       // return the view and pass in the post object
       
       return view('blog.single')->withPost($post);

    }
}
