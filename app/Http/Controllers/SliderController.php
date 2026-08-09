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
        $totalCount = $sliders->count();
        $activeCount = $sliders->where('status', 1)->count();
        $inactiveCount = $sliders->where('status', 0)->count();

        return view('school.admin.slider.index', compact('sliders', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    public function store(Request $request, $tenant)
    {
        $request->validate([
            'image' => 'required_without:cropped_image|nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'cropped_image' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'order_by' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $slider = new Slider();
        $slider->school_id = auth()->user()->school->id;
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->order_by = $request->order_by ?? 0;
        $slider->status = $request->has('status') ? (int)$request->status : 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = "uploads/schools/{$tenant}/sliders";
            
            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true);
            }

            $file->move(public_path($path), $filename);
            $slider->image = $path . '/' . $filename;
        } elseif ($request->filled('cropped_image')) {
            $base64Image = $request->cropped_image;
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $data = substr($base64Image, strpos($base64Image, ',') + 1);
                $type = strtolower($type[1]);
                if (in_array($type, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $data = base64_decode($data);
                    $filename = time() . '_' . uniqid() . '.' . $type;
                    $path = "uploads/schools/{$tenant}/sliders";
                    if (!File::exists(public_path($path))) {
                        File::makeDirectory(public_path($path), 0755, true);
                    }
                    File::put(public_path($path . '/' . $filename), $data);
                    $slider->image = $path . '/' . $filename;
                }
            }
        }

        $slider->save();
        return back()->with('success', 'স্লাইডারটি সফলভাবে যুক্ত করা হয়েছে!');
    }

    public function edit($tenant, $id)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        $slider = Slider::where('school_id', $school->id)->where('id', $id)->firstOrFail();
        $sliders = Slider::where('school_id', $school->id)->orderBy('order_by', 'asc')->get();
        $totalCount = $sliders->count();
        $activeCount = $sliders->where('status', 1)->count();
        $inactiveCount = $sliders->where('status', 0)->count();

        return view('school.admin.slider.edit', compact('slider', 'sliders', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    public function update(Request $request, $tenant, $id)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        $slider = Slider::where('school_id', $school->id)->where('id', $id)->firstOrFail();

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'cropped_image' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'order_by' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->order_by = $request->order_by ?? 0;
        $slider->status = $request->has('status') ? (int)$request->status : 1;

        if ($request->hasFile('image')) {
            // Remove old image if exists
            if (!empty($slider->image) && File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = "uploads/schools/{$tenant}/sliders";
            
            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true);
            }

            $file->move(public_path($path), $filename);
            $slider->image = $path . '/' . $filename;
        } elseif ($request->filled('cropped_image')) {
            // Remove old image if exists
            if (!empty($slider->image) && File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }

            $base64Image = $request->cropped_image;
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $data = substr($base64Image, strpos($base64Image, ',') + 1);
                $type = strtolower($type[1]);
                if (in_array($type, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $data = base64_decode($data);
                    $filename = time() . '_' . uniqid() . '.' . $type;
                    $path = "uploads/schools/{$tenant}/sliders";
                    if (!File::exists(public_path($path))) {
                        File::makeDirectory(public_path($path), 0755, true);
                    }
                    File::put(public_path($path . '/' . $filename), $data);
                    $slider->image = $path . '/' . $filename;
                }
            }
        }

        $slider->save();
        return redirect()->route('sliders.index', ['tenant' => $tenant])->with('success', 'স্লাইডারটি সফলভাবে আপডেট করা হয়েছে!');
    }

    public function destroy($tenant, $id)
    {
        $slider = Slider::findOrFail($id);
        if (File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }
        $slider->delete();
        return back()->with('success', 'স্লাইডারটি মুছে ফেলা হয়েছে!');
    }
}