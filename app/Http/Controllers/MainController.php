<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MainController extends Controller
{
    /**
     * Show main page
     *
     * @return Response
     */
    public function home()
    {
        return view('main.index');
    }

    /**
     * Ajax endpoint to update app_id for user
     * @param Request $request
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

        return 'OK';
    }
}
