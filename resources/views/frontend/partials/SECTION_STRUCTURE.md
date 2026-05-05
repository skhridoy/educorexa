# হোম পেজ সেকশন স্ট্রাকচার

এই ফাইলটি দেখায় কীভাবে হোম পেজটি বিভিন্ন সেকশনে বিভক্ত করা হয়েছে।

## সেকশন ফাইল লিস্ট

### ১. Header Section
- **ফাইল**: `resources/views/frontend/partials/header.blade.php`
- **বিষয়বস্তু**: নেভিগেশন বার, লোগো, মেনু, লগইন/রেজিস্ট্রেশন বাটন

### ২. Hero Section
- **ফাইল**: `resources/views/frontend/partials/hero.blade.php`
- **বিষয়বস্তু**: মেইন হিরো সেকশন, হেডলাইন, সাব-হেডলাইন, CTA বাটন, ড্যাশবোর্ড ইমেজ

### ৩. Features Section
- **ফাইল**: `resources/views/frontend/partials/features.blade.php`
- **বিষয়বস্তু**: ৬টি মূল ফিচার বেন্টো গ্রিড লেআউটে (ওয়েবসাইট, ভর্তি, হাজিরা, রেজাল্ট, একাউন্টস, এসএমএস)

### ৪. Why Choose Us Section
- **ফাইল**: `resources/views/frontend/partials/why_choose_us.blade.php`
- **বিষয়বস্তু**: ৩টি কারণ (কাস্টমার সাপোর্ট, ডাটা সিকিউরিটি, ইউজার ইন্টারফেস)

### ৫. Setup Guide Section
- **ফাইল**: `resources/views/frontend/partials/setup-section.blade.php`
- **বিষয়বস্তু**: ৩টি ধাপ সহজ সেটআপ গাইড (রেজিস্ট্রেশন, কনফিগার, চালু করুন)

### ৬. About Us Section
- **ফাইল**: `resources/views/frontend/partials/about.blade.php`
- **বিষয়বস্তু**: আমাদের লক্ষ্য, ভিশন, মিশন এবং বিষয়বস্তু

### ৭. Pricing Section
- **ফাইল**: `resources/views/frontend/partials/pricing.blade.php`
- **বিষয়বস্তু**: ৩টি প্রাইসিং প্ল্যান (বেসিক, প্রো, এন্টারপ্রাইজ)

### ৮. Testimonials Section
- **ফাইল**: `resources/views/frontend/partials/testimonials.blade.php`
- **বিষয়বস্তু**: গ্রাহকদের রিভিউ এবং রেটিং

### ৯. Contact Us Section
- **ফাইল**: `resources/views/frontend/partials/contact.blade.php`
- **বিষয়বস্তু**: যোগাযোগ ফর্ম এবং যোগাযোগ তথ্য

### ১০. Newsletter Section
- **ফাইল**: `resources/views/frontend/partials/newsletter.blade.php`
- **বিষয়বস্তু**: নিউজলেটার সাবস্ক্রিপশন সেকশন

### ১১. CTA Section
- **ফাইল**: `resources/views/frontend/partials/cta.blade.php`
- **বিষয়বস্তু**: চূড়ান্ত কল-টু-অ্যাকশন সেকশন

### ১২. Footer Section
- **ফাইল**: `resources/views/frontend/partials/footer.blade.php`
- **বিষয়বস্তু**: ফুটার লিংক, যোগাযোগ তথ্য, সোশ্যাল মিডিয়া লিংক

## মূল হোম পেজ ফাইল
- **ফাইল**: `resources/views/frontend/home.blade.php`
- **বিষয়বস্তু**: শুধুমাত্র HTML structure, meta tags, tailwind config এবং সেকশন @include

## রুটিং
- **রুট নাম**: `main.home`
- **রুট পাথ**: `/`
- **কন্ট্রোলার**: `HomeController@index`
- **ফাইল**: `routes/web.php` লাইন ৩৫

## কীভাবে নতুন সেকশন যোগ করবেন

১. `resources/views/frontend/partials/` ফোল্ডারে নতুন `.blade.php` ফাইল তৈরি করুন
২. `home.blade.php` ফাইলে `@include('frontend.partials.your-file-name')` যোগ করুন
৩. সেকশনটি সঠিক স্থানে রাখুন (যেখানে এটি প্রদর্শিত হওয়ার কথা)

## উদাহরণ

```blade
<!-- home.blade.php এ -->
<main class="pt-20 md:pt-24">
    @include('frontend.partials.hero')
    @include('frontend.partials.features')
    <!-- আপনার নতুন সেকশন -->
    @include('frontend.partials.your-new-section')
</main>
```

## সুবিধাগুলি

✅ মডুলার ডিজাইন  
✅ সহজ রক্ষণাবেক্ষণ  
✅ পুনঃব্যবহারযোগ্য কম্পোনেন্ট  
✅ পরিষ্কার কোড অর্গানাইজেশন  
✅ দ্রুত লোডিং সময়
