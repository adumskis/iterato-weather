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
    public function updateAppId(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->route('main.home');
        }

        if (auth()->check()) {
            $user = auth()->user();
            $user->app_id = $request->get('app_id');
            $user->save();
        } else {
            $request->session()->put('app_id', $request->get('app_id'));
        }
    }
}
