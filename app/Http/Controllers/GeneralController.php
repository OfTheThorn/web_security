<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user == null)
            abort(403);
        return response()->streamDownload(function() use ($user) {
            echo $user->toJson();
        }, 'user-details.json');
    }
}
