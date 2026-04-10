<div style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2c3e50;">অভিনন্দন, {{ $school->name ?? 'সম্মানিত প্রধান শিক্ষক' }}!</h2>
    <p>আপনার স্কুলটি এখন <strong>EduCorexa</strong> সিস্টেমে ব্যবহারের জন্য প্রস্তুত। আপনি এখন লগইন করতে পারবেন।</p>
    
    <div style="background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <p style="margin: 5px 0;"><strong>লগইন লিঙ্ক:</strong> <a href="{{ $loginUrl ?? '#' }}">{{ $loginUrl ?? 'লিঙ্ক পাওয়া যায়নি' }}</a></p>
        <p style="margin: 5px 0;"><strong>ইউজার আইডি/ইমেইল:</strong> {{ $school->email ?? 'রেজিস্ট্রেশন ইমেইল' }}</p>
        <p style="margin: 5px 0;"><strong>পাসওয়ার্ড:</strong> (আপনার রেজিস্ট্রেশনের সময় দেওয়া পাসওয়ার্ডটি ব্যবহার করুন)</p>
    </div>

    <p style="margin-top: 20px;">কোনো সমস্যা হলে আমাদের সাপোর্ট টিমে যোগাযোগ করুন।</p>
    <p>ধন্যবাদ,<br><strong>EduCorexa টিম</strong></p>
</div>