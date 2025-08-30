<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZaloController extends Controller
{
    public function getPhone(Request $request)
    {
        $accessToken = $request->get('accessToken');
        return response()->json([
            'data' => $accessToken
        ]);
    }
}
