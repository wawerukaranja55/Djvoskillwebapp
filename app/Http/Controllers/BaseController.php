<?php

namespace App\Http\Controllers;

use App\Models\Events_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    public function __construct()
  {
    //its just a dummy data object.
    $events=Events_Model::latest()->take(4)->get();

    // Sharing is caring
    View::share('events', $events);
  }
}
