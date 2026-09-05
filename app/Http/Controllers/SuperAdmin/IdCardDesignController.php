<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\IdCardDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class IdCardDesignController extends Controller
{
    private string $uploadDir = 'uploads/id_card_designs';

    // ── INDEX ────────────────────────────────────────────────
    public function index()
    {
        $designs = IdCardDesign::orderBy('sort_order')->orderBy('id')->get();
        return view('super.id-card-designs.index', compact('designs'));
    }

    // ── CREATE ───────────────────────────────────────────────
    public function create()
    {
        return view('super.id-card-designs.create');
    }

    // ── STORE ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:100',
            'slug'               => 'nullable|string|max:60|unique:id_card_designs,slug',
            'header_shape'       => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'gradient_bar'       => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'pattern'            => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'primary_color'      => 'required|string|max:20',
            'badge_color'        => 'required|string|max:20',
            'label_color'        => 'required|string|max:20',
            'photo_border_color' => 'required|string|max:20',
            'back_header_bg'     => 'required|string|max:20',
            'back_header_text'   => 'required|string|max:20',
            'sort_order'         => 'nullable|integer',
        ]);

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        // Ensure slug is unique
        $slug = $this->uniqueSlug($slug);

        $dir = public_path("{$this->uploadDir}/{$slug}");
        File::ensureDirectoryExists($dir, 0755);

        $data = [
            'name'               => $request->name,
            'slug'               => $slug,
            'primary_color'      => $request->primary_color,
            'badge_color'        => $request->badge_color,
            'label_color'        => $request->label_color,
            'photo_border_color' => $request->photo_border_color,
            'back_header_bg'     => $request->back_header_bg,
            'back_header_text'   => $request->back_header_text,
            'is_active'          => $request->has('is_active'),
            'sort_order'         => $request->sort_order ?? 0,
        ];

        foreach (['header_shape', 'gradient_bar', 'pattern'] as $field) {
            if ($request->hasFile($field)) {
                $filename = $field . '.' . $request->file($field)->getClientOriginalExtension();
                $request->file($field)->move($dir, $filename);
                $data[$field] = "{$this->uploadDir}/{$slug}/{$filename}";
            }
        }

        IdCardDesign::create($data);

        return redirect()->route('super.id-card-designs.index')
            ->with('success', 'নতুন ডিজাইন সফলভাবে যোগ করা হয়েছে!');
    }

    // ── SHOW (unused, redirect to edit) ─────────────────────
    public function show(IdCardDesign $idCardDesign)
    {
        return redirect()->route('super.id-card-designs.edit', $idCardDesign);
    }

    // ── EDIT ─────────────────────────────────────────────────
    public function edit(IdCardDesign $idCardDesign)
    {
        return view('super.id-card-designs.edit', ['design' => $idCardDesign]);
    }

    // ── UPDATE ───────────────────────────────────────────────
    public function update(Request $request, IdCardDesign $idCardDesign)
    {
        $request->validate([
            'name'               => 'required|string|max:100',
            'header_shape'       => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'gradient_bar'       => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'pattern'            => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'primary_color'      => 'required|string|max:20',
            'badge_color'        => 'required|string|max:20',
            'label_color'        => 'required|string|max:20',
            'photo_border_color' => 'required|string|max:20',
            'back_header_bg'     => 'required|string|max:20',
            'back_header_text'   => 'required|string|max:20',
            'sort_order'         => 'nullable|integer',
        ]);

        $dir = public_path("{$this->uploadDir}/{$idCardDesign->slug}");
        File::ensureDirectoryExists($dir, 0755);

        $data = [
            'name'               => $request->name,
            'primary_color'      => $request->primary_color,
            'badge_color'        => $request->badge_color,
            'label_color'        => $request->label_color,
            'photo_border_color' => $request->photo_border_color,
            'back_header_bg'     => $request->back_header_bg,
            'back_header_text'   => $request->back_header_text,
            'is_active'          => $request->has('is_active'),
            'sort_order'         => $request->sort_order ?? $idCardDesign->sort_order,
        ];

        foreach (['header_shape', 'gradient_bar', 'pattern'] as $field) {
            if ($request->hasFile($field)) {
                // Delete old file
                if ($idCardDesign->$field && file_exists(public_path($idCardDesign->$field))) {
                    unlink(public_path($idCardDesign->$field));
                }
                $filename = $field . '.' . $request->file($field)->getClientOriginalExtension();
                $request->file($field)->move($dir, $filename);
                $data[$field] = "{$this->uploadDir}/{$idCardDesign->slug}/{$filename}";
            }
        }

        $idCardDesign->update($data);

        return redirect()->route('super.id-card-designs.index')
            ->with('success', 'ডিজাইন সফলভাবে আপডেট করা হয়েছে!');
    }

    // ── DESTROY ──────────────────────────────────────────────
    public function destroy(IdCardDesign $idCardDesign)
    {
        // Delete the whole folder for this design
        $dir = public_path("{$this->uploadDir}/{$idCardDesign->slug}");
        if (File::isDirectory($dir)) {
            File::deleteDirectory($dir);
        }
        $idCardDesign->delete();

        return redirect()->route('super.id-card-designs.index')
            ->with('success', 'ডিজাইন মুছে ফেলা হয়েছে।');
    }

    // ── TOGGLE STATUS ─────────────────────────────────────────
    public function toggleStatus(IdCardDesign $idCardDesign)
    {
        $idCardDesign->update(['is_active' => !$idCardDesign->is_active]);
        $status = $idCardDesign->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়';
        return redirect()->route('super.id-card-designs.index')
            ->with('success', "ডিজাইনটি {$status} করা হয়েছে।");
    }

    // ── Helper: ensure unique slug ────────────────────────────
    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug   = $base;
        $suffix = 1;
        $query  = IdCardDesign::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        while ($query->exists()) {
            $slug  = $base . '-' . $suffix++;
            $query = IdCardDesign::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }
        return $slug;
    }
}
