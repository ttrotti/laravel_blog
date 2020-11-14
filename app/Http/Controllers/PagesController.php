<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Mail;
use Session;


class PagesController extends Controller {

    public function getIndex() {
        # process variable data or parameters
        # talk to the model
        # receive data from the model
        # compile or process the data again
        # pass that data to the correct view

        // con hacer Post:: sin especificar, está seleccionando '*'
        $posts = Post::orderBy('created_at', 'desc')->limit(4)->get();
        return view('pages.welcome')->withPosts($posts);
    }

    public function getAbout() {
        $first = "Tomas";
        $last = "Trotti";

        $fullname = $first . " " . $last;
        $email = "tomasftrotti@gmail.com";
        $data = [];
        $data['email'] = $email;
        $data['fullname'] = $fullname;
        return view('pages.about')->withData($data);
    }

    public function getContact() {
        return view('pages.contact');
    }

    public function postContact(Request $request) {
        $this->validate($request, 
        ['email' => 'required|email',
        'subject' => 'min:3',
        'message' => 'min:10']);

        //Mail::send('view', $data (array), function(){});
        
        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        );

        Mail::send('emails.contact', $data, function($message) use($data){
            $message->from($data['email']);
            $message->to('tomasftrotti@gmail.com');
            $message->subject($data['subject']);
        } );

        Session::flash('success', 'Your Email was sent!');

        return view('pages.contact');

    }

}


?>