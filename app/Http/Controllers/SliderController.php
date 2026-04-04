<?php 

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function index($tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        $sliders = Slider::where('school_id', $school->id)->orderBy('order_by', 'asc')->get();
        return view('school.admin.slider.index', compact('sliders'));
    }

    public function store(Request $request, $tenant)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'title' => 'nullable|string|max:255',
            'order_by' => 'nullable|integer',
        ]);

        $slider = new Slider();
        $slider->school_id = auth()->user()->school->id;
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->order_by = $request->order_by ?? 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = "uploads/schools/{$tenant}/sliders";
            
            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true);
            }

            $file->move(public_path($path), $filename);
            $slider->image = $path . '/' . $filename;
        }

        $slider->save();
        return back()->with('success', 'This slider added successfully!');
    }

    public function destroy($tenant, $id)
    {
        $slider = Slider::findOrFail($id);
        if (File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }
        $slider->delete();
        return back()->with('success', 'স্লাইডারটি মুছে ফেলা হয়েছে!');
    }
}