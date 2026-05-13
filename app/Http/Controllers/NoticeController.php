<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\School;
use App\Models\Student;
use App\Mail\NoticeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Traits\SchoolMailConfig;

class NoticeController extends Controller
{
    use SchoolMailConfig;
    // নোটিশের তালিকা দেখানো
    public function index($tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        $notices = Notice::where('school_id', $school->id)
                        ->orderBy('notice_date', 'desc')
                        ->get();

        return view('school.admin.notice.index', compact('notices'));
    }

    // নতুন নোটিশ সেভ করা
    public function store(Request $request, $tenant)
    {
        $school = School::where('slug', $tenant)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'notice_date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048', // ২ এমবি লিমিট
        ]);

        $notice = new Notice();
        $notice->school_id = $school->id;
        $notice->title = $request->title;
        $notice->notice_date = $request->notice_date;
        $notice->description = $request->description;

        // ফাইল হ্যান্ডলিং
        if ($request->hasFile('file')) {
            $folderPath = public_path("uploads/schools/{$tenant}/notices");
            
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            $file = $request->file('file');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $file->move($folderPath, $filename);
            
            $notice->file = "uploads/schools/{$tenant}/notices/" . $filename;
        }

        $notice->save();

        return back()->with('success', 'নোটিশটি সফলভাবে তৈরি করা হয়েছে!');
    }

    // নোটিশ ডিলিট করা
    public function destroy($tenant, $id)
    {
        $notice = Notice::findOrFail($id);

        // ফাইল থাকলে ডিলিট করা
        if ($notice->file && File::exists(public_path($notice->file))) {
            File::delete(public_path($notice->file));
        }

        $notice->delete();

        return back()->with('success', 'নোটিশটি মুছে ফেলা হয়েছে!');
    }

    // নোটিশ শিক্ষার্থীদের কাছে পাঠানো (Email/WhatsApp)
    public function sendToStudents(Request $request, $tenant, $id)
    {
        $school = School::where('slug', $tenant)->firstOrFail();
        $notice = Notice::where('school_id', $school->id)->findOrFail($id);
        $method = $request->method_type; // 'email' or 'whatsapp'
        
        // Dynamically set Mail Config if school has SMTP settings
        if ($method === 'email' && $school->mail_host) {
            $this->setMailConfig($school);
        }

        $students = Student::where('school_id', $school->id)
                          ->where('status', 'active')
                          ->with('user')
                          ->get();

        if ($students->isEmpty()) {
            return back()->with(['success' => 'কোন সক্রিয় শিক্ষার্থী পাওয়া যায়নি!', 'type' => 'error']);
        }

        $successCount = 0;
        $failCount = 0;

        foreach ($students as $student) {
            if ($method === 'email') {
                if ($student->user && $student->user->email) {
                    try {
                        Mail::to($student->user->email)->send(new NoticeMail($notice, $school));
                        $successCount++;
                    } catch (\Exception $e) {
                        Log::error("Notice Email Failed for student {$student->user->email}: " . $e->getMessage());
                        $failCount++;
                    }
                }
            } elseif ($method === 'whatsapp') {
                if ($student->contact_number) {
                    $sent = $this->sendWhatsAppMessage($student->contact_number, $notice, $school);
                    if ($sent) $successCount++;
                    else $failCount++;
                }
            }
        }

        $msg = "নোটিশটি {$successCount} জন শিক্ষার্থীকে পাঠানো হয়েছে।";
        if ($failCount > 0) $msg .= " ({$failCount} জন ব্যর্থ হয়েছে)";

        return back()->with('success', $msg);
    }

    private function sendWhatsAppMessage($number, $notice, $school)
    {
        $message = "*Notice: {$notice->title}*\n\n";
        $message .= "{$notice->description}\n\n";
        if ($notice->file) {
            $message .= "View Document: " . url($notice->file) . "\n\n";
        }
        $message .= "_Sent from {$school->name}_";

        // Clean number
        $number = preg_replace('/[^0-9]/', '', $number);
        if (strlen($number) == 11 && str_starts_with($number, '01')) {
            $number = '88' . $number;
        }

        // Use School's WhatsApp API if configured
        if ($school->whatsapp_api_key && $school->whatsapp_api_instance_id) {
            if ($school->whatsapp_api_provider === 'ultramsg') {
                $response = Http::post("https://api.ultramsg.com/{$school->whatsapp_api_instance_id}/messages/chat", [
                    'token' => $school->whatsapp_api_key,
                    'to' => $number,
                    'body' => $message
                ]);
                
                if (!$response->successful()) {
                    Log::error("WhatsApp API Error ({$school->whatsapp_api_provider}): " . $response->body());
                }
                
                return $response->successful();
            }
            // Add other providers here if needed
        }

        return true; 
    }

    private function setMailConfig($school)
    {
        $encryption = $school->mail_encryption;
        
        // Port 465 usually requires SSL
        if ($school->mail_port == 465 && (empty($encryption) || $encryption == 'none')) {
            $encryption = 'ssl';
        }

        Config::set('mail.mailers.smtp.host', $school->mail_host);
        Config::set('mail.mailers.smtp.port', $school->mail_port ?? 587);
        Config::set('mail.mailers.smtp.encryption', $encryption ?? 'tls');
        Config::set('mail.mailers.smtp.username', $school->mail_username);
        Config::set('mail.mailers.smtp.password', $school->mail_password);
        Config::set('mail.from.address', $school->mail_from_address ?? $school->email);
        Config::set('mail.from.name', $school->mail_from_name ?? $school->name);

        // Purge the mailer to apply new config
        Mail::purge('smtp');
    }
}