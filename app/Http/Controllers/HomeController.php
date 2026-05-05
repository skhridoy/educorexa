<?php

namespace App\Http\Controllers;
use App\Models\FrontendSection;
use App\Models\SubscriptionPackage;
use App\Models\Testimonial; 

class HomeController extends Controller
{
    public function index()
    {
        // ডাটাবেজ থেকে একটিভ সেকশনগুলো সিরিয়াল অনুযায়ী নিয়ে আসা
        $sections = FrontendSection::where('status', 1)
                                   ->orderBy('order', 'asc')
                                   ->get();

        $packages = SubscriptionPackage::where('is_active', true)->get();
        $testimonials = Testimonial::where('is_active', true)->latest()->get();

        // ভিউ ফাইলে ডাটা পাস করা
        return view('frontend.home', compact('sections', 'packages', 'testimonials'));
    }
}
