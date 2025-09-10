<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ZaloController extends Controller
{
    public function getPhoneNumber(Request $request)
    {
        // Validate input từ Mini App
        $request->validate([
            'access_token' => 'required|string',
            'code' => 'required|string',
        ]);

        $accessToken = $request->input('access_token');
        $code = $request->input('code');
        $secretKey = env('ZALO_CLIENT_SECRET');

        // Gọi API Zalo để decode phone
        $response = Http::withHeaders([
            'access_token' => $accessToken,
            'code' => $code,
            'secret_key' => $secretKey,
        ])->get('https://graph.zalo.me/v2.0/me/info');

        // Xử lý response
        if ($response->successful()) {
            $data = $response->json();
            if ($data['error'] === 0) {
                return response()->json([
                    'message' => 'Lấy số điện thoại thành công',
                    'number' => $data['data']['number'] ?? null, // Số điện thoại dạng "849123456789"
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Lỗi từ Zalo API',
                    'details' => $data['message'],
                    'error_code' => $data['error'],
                ], 400);
            }
        } else {
            return response()->json([
                'error' => 'Kết nối API thất bại',
                'details' => $response->body(),
            ], $response->status());
        }
    }
    public function getPhone(Request $request)
    {
        $accessToken = $request->get('accessToken');
        return response()->json([
            'data' => $accessToken
        ]);
    }
}
