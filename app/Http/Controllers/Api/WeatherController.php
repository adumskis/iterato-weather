<?php

namespace App\Http\Controllers\Api;

use App\Facades\Weather;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    public function current(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'app_id' => 'required',
            'query'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        try {
            $data = Weather::appId($request->get('app_id'))->query($request->get('query'))->raw();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json($data);
    }
}
