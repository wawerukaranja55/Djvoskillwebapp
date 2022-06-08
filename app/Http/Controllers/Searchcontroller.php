<?php

namespace App\Http\Controllers;

use App\Models\Blogtag;
use App\Models\Blogpost;
use App\Models\Blogcategory;
use App\Models\Events;
use App\Models\Events_Model;
use Illuminate\Http\Request;

class Searchcontroller extends Controller
{
    public function index(Request $request)
    {
        $events=Events::latest()->take(4)->get();
        $cats=Blogcategory::all();
        $recent_posts= Blogpost::latest()->limit(5)->get();
        $posttags=Blogtag::all();
        $request->validate([
            'query'=>'required|min:2',
        ]);
        $query=$request->input('query');
        $data=Blogpost::where('blo_title','like','%'.request('query').'%')->
                        orwhere('blo_details','like','%'.request('query').'%')->paginate(1);
        return view('frontend.searchpage',compact('data','events','cats','recent_posts','posttags'));
    }
}
