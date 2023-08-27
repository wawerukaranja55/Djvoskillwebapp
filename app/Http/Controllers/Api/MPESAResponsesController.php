<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MPESAResponsesController extends Controller
{
    public function confirmTrsction(Request $request){
        Log::info("succeded");
    }

    public function validateTrsction(Request $request){
        Log::info($request);
    }
}
