<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\FrontendSection;

class FrontendSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // php artisan make:seeder FrontendSectionSeeder
    public function run(): void
    {
        $sections = [
            ['key' => 'hero', 'title' => 'Hero Section', 'order' => 1],
            ['key' => 'features', 'title' => 'Features Section', 'order' => 2],
            ['key' => 'why_choose_us', 'title' => 'Why Choose Us', 'order' => 3],
            ['key' => 'setup-section', 'title' => 'Setup Section', 'order' => 4],
            ['key' => 'pricing', 'title' => 'Pricing Table', 'order' => 5],
            ['key' => 'about', 'title' => 'About Us', 'order' => 6],
            ['key' => 'testimonials', 'title' => 'Testimonials', 'order' => 7],
            ['key' => 'contact', 'title' => 'Contact Section', 'order' => 8],
            [
                'key' => 'blogs', 
                'title' => 'Blog Slider', 
                'order' => 9,
                'content' => json_encode([
                    'badge_text' => 'আমাদের ব্লগ ও খবর',
                    'title' => 'সর্বশেষ আপডেট ও শিক্ষামূলক প্রবন্ধ',
                    'description' => 'আমাদের প্রতিষ্ঠানের সর্বশেষ খবর, ঘটনা এবং শিক্ষামূলক ব্লগ পোস্টগুলো এখানে পড়ুন।'
                ])
            ],
        ];

        foreach ($sections as $section) {
            FrontendSection::updateOrCreate(['key' => $section['key']], $section);
        }

        // Seed default categories
        $categoriesMap = [
            'শিক্ষা প্রযুক্তি' => \App\Models\BlogCategory::updateOrCreate(['slug' => 'edtech'], ['name' => 'শিক্ষা প্রযুক্তি (EdTech)', 'status' => true]),
            'পরামর্শ' => \App\Models\BlogCategory::updateOrCreate(['slug' => 'tips-guides'], ['name' => 'পরামর্শ (Tips/Guides)', 'status' => true]),
            'ইভেন্ট' => \App\Models\BlogCategory::updateOrCreate(['slug' => 'events'], ['name' => 'ইভেন্ট (Events)', 'status' => true]),
            'ডিজিটাল শিক্ষা' => \App\Models\BlogCategory::updateOrCreate(['slug' => 'digital-learning'], ['name' => 'ডিজিটাল শিক্ষা (Digital Learning)', 'status' => true]),
            'নোটিশ' => \App\Models\BlogCategory::updateOrCreate(['slug' => 'announcements'], ['name' => 'নোটিশ (Announcements)', 'status' => true]),
            'শিক্ষার্থী কর্নার' => \App\Models\BlogCategory::updateOrCreate(['slug' => 'student-corner'], ['name' => 'শিক্ষার্থী কর্নার (Student Corner)', 'status' => true]),
        ];

        // Seed default blogs if empty
        if (\App\Models\Blog::count() === 0) {
            $demoBlogs = [
                [
                    'title' => 'স্মার্ট স্কুল ম্যানেজমেন্ট সিস্টেমের সুবিধা ও কার্যকারিতা',
                    'slug' => 'smart-school-management-system-benefits',
                    'category' => 'শিক্ষা প্রযুক্তি',
                    'author' => 'এডমিন',
                    'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop',
                    'content' => 'একটি আধুনিক ও প্রযুক্তি নির্ভর শিক্ষা প্রতিষ্ঠান পরিচালনায় ইআরপি সফটওয়্যারের ভূমিকা অপরিসীম। এটি শিক্ষক, শিক্ষার্থী এবং অভিভাবকদের কাজের সমন্বয় সহজ করে। ডিজিটাল অ্যাটেনডেন্স থেকে শুরু করে অনলাইন ফি আদায়, রেজাল্ট শিট প্রস্তুত করা সহ স্কুলের প্রতিদিনের কার্যক্রমকে স্বয়ংক্রিয় ও নির্ভুল করে তোলে।',
                    'status' => true,
                ],
                [
                    'title' => 'শিক্ষার্থীদের মনোযোগ বৃদ্ধিতে শিক্ষকদের ভূমিকা',
                    'slug' => 'teachers-role-in-boosting-student-focus',
                    'category' => 'পরামর্শ',
                    'author' => 'ফারহানা রহমান',
                    'image' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=800&auto=format&fit=crop',
                    'content' => 'শ্রেণীকক্ষে শিক্ষার্থীদের মনোযোগ আকর্ষণ ও তা ধরে রাখা প্রতিটি শিক্ষকের জন্যই একটি বড় চ্যালেঞ্জ। আধুনিক শিক্ষা পদ্ধতিতে মুখস্থ বিদ্যার চেয়ে ইন্টারেক্টিভ লার্নিং বা প্রশ্নোত্তরের মাধ্যমে পাঠদান করা বেশি কার্যকর। এছাড়া মাঝে মাঝে ছোট গ্রুপ স্টাডি বা কুইজের আয়োজন করলে শিক্ষার্থীরা পড়ালেখায় বেশি মনোযোগী হয়।',
                    'status' => true,
                ],
                [
                    'title' => 'নতুন শিক্ষাবর্ষের বার্ষিক ক্রীড়া প্রতিযোগিতা ও পুরষ্কার বিতরণী',
                    'slug' => 'annual-sports-competition-new-academic-year',
                    'category' => 'ইভেন্ট',
                    'author' => 'ক্রীড়া শিক্ষক',
                    'image' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800&auto=format&fit=crop',
                    'content' => 'উৎসাহ ও উদ্দীপনার মধ্য দিয়ে উদযাপিত হলো আমাদের প্রতিষ্ঠানের বার্ষিক ক্রীড়া প্রতিযোগিতা। শিক্ষার্থীরা বিভিন্ন খেলাধূলায় অংশ নিয়ে তাদের প্রতিভা প্রদর্শন করেছে। প্রতিযোগিতা শেষে স্কুলের অধ্যক্ষ মহোদয় বিজয়ী শিক্ষার্থীদের হাতে মেডেল ও চ্যাম্পিয়ন ট্রফি তুলে দেন।',
                    'status' => true,
                ],
                [
                    'title' => 'ডিজিটাল ক্লাসরুম যেভাবে পাঠদানকে সহজ করছে',
                    'slug' => 'how-digital-classrooms-simplify-teaching',
                    'category' => 'ডিজিটাল শিক্ষা',
                    'author' => 'সাকিব আল হাসান',
                    'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop',
                    'content' => 'প্রজেক্টর ও মাল্টিমিডিয়া ক্লাসরুমের ব্যবহার শিক্ষার্থীদের পড়া সহজে বুঝতে এবং দীর্ঘক্ষণ মনে রাখতে দারুণ সহায়তা করছে। জটিল বৈজ্ঞানিক ফর্মুলা বা ঐতিহাসিক ঘটনাগুলো ভিডিও চিত্রের মাধ্যমে দেখানোর ফলে শিক্ষার্থীরা ক্লাসের পড়া দ্রুত আত্মস্থ করতে পারছে, যা ঐতিহ্যবাহী পাঠদানের চেয়ে অনেক বেশি কার্যকর।',
                    'status' => true,
                ],
                [
                    'title' => 'অভিভাবক-শিক্ষক সভা: শিক্ষার্থীদের সার্বিক উন্নয়ন নিশ্চিতকরণ',
                    'slug' => 'parent-teacher-meeting-ensuring-student-growth',
                    'category' => 'নোটিশ',
                    'author' => 'অধ্যক্ষ',
                    'image' => 'https://images.unsplash.com/photo-1544531516-a5e34e2d3df3?q=80&w=800&auto=format&fit=crop',
                    'content' => 'শিক্ষার্থীদের পড়ালেখার মানোন্নয়ন ও আচরণগত উন্নতির লক্ষ্যে অভিভাবক ও শিক্ষক মতবিনিময় সভার আয়োজন করা হয়েছিল। সভায় শিক্ষকদের পক্ষ থেকে শিক্ষার্থীদের দুর্বলতা ও শক্তিগুলো তুলে ধরা হয় এবং অভিভাবকেরা তাদের মূল্যবান মতামত শেয়ার করেন। সম্মিলিত প্রচেষ্টায় শিক্ষার্থীদের আগামী দিনে এগিয়ে নেওয়ার সিদ্ধান্ত গৃহীত হয়।',
                    'status' => true,
                ],
                [
                    'title' => 'পরীক্ষার ভীতি দূর করার ৫টি সহজ বৈজ্ঞানিক উপায়',
                    'slug' => '5-scientific-ways-to-reduce-exam-fear',
                    'category' => 'শিক্ষার্থী কর্নার',
                    'author' => 'ডা. আরমান হোসেন',
                    'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800&auto=format&fit=crop',
                    'content' => 'পরীক্ষার আগে মানসিক চাপ কমানো এবং স্মৃতিশক্তি বৃদ্ধির জন্য কার্যকরী কিছু বৈজ্ঞানিক টিপস রয়েছে। প্রথমত, নিয়মিত ও পর্যাপ্ত ঘুম নিশ্চিত করা। দ্বিতীয়ত, পড়ার মাঝে ছোট বিরতি (পোমোডোরো টেকনিক) নেওয়া। তৃতীয়ত, গ্রুপ ডিসকাশন করা এবং quarto, রিভিশনের জন্য ফ্ল্যাশকার্ড ব্যবহার করা।',
                    'status' => true,
                ]
            ];

            foreach ($demoBlogs as $dblog) {
                $catName = $dblog['category'];
                if (isset($categoriesMap[$catName])) {
                    $dblog['blog_category_id'] = $categoriesMap[$catName]->id;
                }
                \App\Models\Blog::create($dblog);
            }
        }
    }
}
