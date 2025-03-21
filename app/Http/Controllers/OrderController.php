<?php
// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        // Logic xử lý đặt hàng
        return response()->json(['message' => 'Đặt hàng thành công!', 'user' => $user], 200);
    }
}
