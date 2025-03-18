<?php
// app/Http/Controllers/SliderController.php
namespace App\Http\Controllers;

use App\Models\Slider;
use App\Http\Requests\StoreSliderRequest;
use Illuminate\Support\Facades\Gate;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)->orderBy('order')->get();
        return response()->json($sliders);
    }

    public function store(StoreSliderRequest $request)
    {
        Gate::authorize('create', Slider::class);
        $slider = Slider::create($request->all());
        return response()->json($slider, 201);
    }

    public function show(Slider $slider)
    {
        return response()->json($slider);
    }

    public function update(StoreSliderRequest $request, Slider $slider)
    {
        Gate::authorize('update', $slider);
        $slider->update($request->all());
        return response()->json($slider);
    }

    public function destroy(Slider $slider)
    {
        Gate::authorize('delete', $slider);
        $slider->delete();
        return response()->json(null, 204);
    }
}
