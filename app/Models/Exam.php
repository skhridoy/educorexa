<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $school_id
 * @property int|null $school_category_id  (legacy — use categories() relation)
 * @property int $year_id
 * @property string $name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_published
 * @property string|null $published_at
 * @property string|null $admit_card_instruction
 * @property-read \App\Models\AcademicYear $academicYear
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SchoolCategory> $categories
 * @property-read int|null $categories_count
 * @property-read mixed $exam_state
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Mark> $marks
 * @property-read int|null $marks_count
 * @property-read \App\Models\School $school
 * @mixin \Eloquent
 */
class Exam extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'year_id',
        'school_category_id', // kept for backward compatibility
        'status',
        'start_date',
        'end_date',
        'admit_card_instruction',
    ];

    /**
     * প্রবেশপত্রে নির্দেশনাবলী সেট না করা থাকলে ব্যবহৃত ডিফল্ট নির্দেশনা।
     */
    public static function defaultAdmitCardInstructions(): array
    {
        return [
            'পরীক্ষার্থীকে অবশ্যই প্রবেশপত্র সঙ্গে আনতে হবে এবং চেকিংয়ের জন্য প্রস্তুত রাখতে হবে।',
            'প্রবেশপত্র ছাড়া কোনও পরীক্ষার্থী পরীক্ষা কেন্দ্রে প্রবেশ করতে পারবে না।',
            'পরীক্ষা আরম্ভ হওয়ার ৩০ মিনিট পূর্বে পরীক্ষার্থীকে নিজ আসনে বসতে হবে।',
            'পরীক্ষা শুরু হওয়ার পর কোনও পরীক্ষার্থী পরীক্ষা কেন্দ্র ত্যাগ করতে পারবে না।',
            'পরীক্ষার কক্ষে মোবাইল ফোন, স্মার্ট ওয়াচ, ক্যালকুলেটর বা কোনও প্রকার ইলেকট্রনিক ডিভাইস আনা সম্পূর্ণ নিষিদ্ধ।',
            'প্রশ্নপত্রের সঙ্গে দেওয়া উত্তরপত্র ছাড়া অন্য কোনও কাগজ ব্যবহার করা যাবে না।',
            'প্রবেশপত্র যত্নসহকারে সংরক্ষণ করতে হবে; পরীক্ষা শেষ না হওয়া পর্যন্ত ইহা প্রযোজ্য।',
            'কোন প্রশ্নে আপত্তি থাকলে পরীক্ষার সময়ই হল পরিদর্শককে লিখিতভাবে জানাতে হবে; পরে কোনও অভিযোগ গ্রহণ করা হবে না।',
        ];
    }

    /**
     * প্রবেশপত্রে প্রদর্শনযোগ্য নির্দেশনার লাইনসমূহ (ডাটাবেজে সেট করা থাকলে সেটাই, নাহলে ডিফল্ট)।
     */
    public function admitCardInstructions(): array
    {
        $instruction = trim((string) ($this->admit_card_instruction ?? ''));

        if ($instruction === '') {
            return static::defaultAdmitCardInstructions();
        }

        $lines = preg_split('/\r\n|\r|\n/', $instruction);
        $lines = array_values(array_filter(array_map('trim', $lines), fn ($line) => $line !== ''));

        return $lines;
    }

    public function school(){
        return $this->belongsTo(School::class);
    }

    public function academicYear() {
        return $this->belongsTo(AcademicYear::class, 'year_id');
    }

    /**
     * Many-to-Many: An exam can belong to multiple school categories
     */
    public function categories()
    {
        return $this->belongsToMany(SchoolCategory::class, 'exam_categories', 'exam_id', 'school_category_id')
                    ->withTimestamps();
    }

    /**
     * Legacy single-category accessor (returns first category for backward compat)
     */
    public function category()
    {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }

    /**
     * Check if this exam applies to a given category ID
     */
    public function appliesToCategory(int $categoryId): bool
    {
        // Check pivot table first (new system)
        if ($this->relationLoaded('categories')) {
            return $this->categories->contains('id', $categoryId);
        }
        return $this->categories()->where('school_category_id', $categoryId)->exists();
    }

    public function getExamStateAttribute()
    {
        $today = Carbon::today();
        $start = $this->start_date ? Carbon::parse($this->start_date) : null;
        $end   = $this->end_date ? Carbon::parse($this->end_date) : null;

        // পরীক্ষার সময় শেষ হয়ে গেলে সেটি অটোমেটিক finished হবে
        if ($end && $today->gt($end)) {
            return 'finished';
        }

        if ($this->status == 0) {
            return 'inactive';
        }

        if ($start && $end && $today->between($start, $end)) {
            return 'ongoing';
        }

        if ($start && $today->lt($start)) {
            return 'upcoming';
        }

        return 'finished';
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
