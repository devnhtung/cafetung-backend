<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where('is_active', true)->get();
        return response()->json([
            'data' => $stores->map(function ($store) {
                $formattedHours = [];
                foreach ($store->opening_hours as $entry) {
                    $formattedHours[$entry['day']] = [
                        'open_time' => $entry['open_time'],
                        'close_time' => $entry['close_time'],
                    ];
                }
                return [
                    'id' => $store->id,
                    'name' => $store->name,
                    'address' => $store->address,
                    'latitude' => $store->latitude,
                    'longitude' => $store->longitude,
                    'phone' => $store->phone,
                    'opening_hours' => $formattedHours,
                    'image' => $store->image,
                    'is_active' => $store->is_active,
                ];
            }),
            'message' => 'Stores retrieved successfully',
        ]);
    }
}
