<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function home()
    {
        return view('main.index');
    }

    /**
     * Update API token
     *
     * @return  Response
     */
    public function updateToken(Request $request)
    {
        dd($request->validate([
            'api_token' => 'required'
        ]));
    }
}
