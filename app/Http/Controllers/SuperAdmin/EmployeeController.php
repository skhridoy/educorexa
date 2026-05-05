<?php 

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\Event;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeRegistrationMail;

class EmployeeController extends Controller
{
    public function dashboard() {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();
        
        $totalSchools = School::count();
        $upcomingEvents = Event::where('event_date', '>=', now())
                               ->where('is_active', true)
                               ->orderBy('event_date', 'asc')
                               ->take(5)
                               ->get();

        return view('super.employee.dashboard', compact('user', 'employee', 'totalSchools', 'upcomingEvents'));
    }

    public function index()
    {
        $employees = User::whereHas('employee') 
        ->with('employee')
        ->latest()
        ->get();

        return view('super.employee.index', compact('employees'));
    }

    public function create() {
        $roles = Role::where('role_type', 'employee')
                     ->where('name', '!=', 'super_admin') 
                     ->get();
        return view('super.employee.create', compact('roles'));
    }

public function store(Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'nullable|min:6', // এখানে nullable করে দেওয়া হয়েছে
        'designation' => 'required',
        'joining_date' => 'required|date',
        'salary' => 'required|numeric',
        'role' => 'required' 
    ]);

    try {
        DB::beginTransaction();

        $role = Role::where('name', $request->role)->first();
        if (!$role) {
            throw new \Exception('নির্বাচিত রোলটি পাওয়া যায়নি।');
        }

        // পাসওয়ার্ড ইনপুটে না থাকলে ডিফল্ট '12345678' সেট হবে
        $plainPassword = $request->filled('password') ? $request->password : '12345678';

        // ১. ইউজার তৈরি
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($plainPassword),
            'role'      => $role->name,
            'school_id' => null, 
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole($role->name);
        }

        // ২. এমপ্লয়ি আইডি জেনারেট
        $lastEmp = Employee::latest('id')->first();
        $nextId = $lastEmp ? ($lastEmp->id + 1) : 1;
        $employee_id = 'EMP-' . date('Y') . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // ৩. এমপ্লয়ি প্রোফাইল তৈরি
        Employee::create([
            'user_id'         => $user->id,
            'employee_id'     => $employee_id,
            'designation'     => $request->designation,
            'phone_personal'  => $request->phone_personal ?? null,
            'address'         => $request->address ?? null,
            'joining_date'    => $request->joining_date,
            'salary'          => $request->salary,
            'status'          => 'active',
        ]);

        // ৪. ইমেইল ডাটা
        $details = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $plainPassword, // এখানে ডিফল্ট বা ইনপুট দেওয়া পাসওয়ার্ডটিই যাবে
            'url'      => route('employee.login.form'),
        ];

        DB::commit();

        // ৫. ইমেইল পাঠানোর চেষ্টা
        try {
            Mail::to($request->email)->send(new EmployeeRegistrationMail($details));
            $message = 'Employee registered and credentials sent via email.';
        } catch (\Exception $mailError) {
            $message = 'Employee registered with default password, but email failed.';
        }

        return redirect()->route('super.employees.index')->with('success', $message);

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
    }
}

    // --- এডিট মেথড ---
    public function edit($id)
    {
        $employee = User::with('employee')->findOrFail($id);
        $roles = Role::where('role_type', 'employee')
                     ->where('name', '!=', 'super_admin') 
                     ->get();
        return view('super.employee.edit', compact('employee', 'roles'));
    }

    // --- আপডেট মেথড ---
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $employee = Employee::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'designation' => 'required',
            'salary' => 'required|numeric',
            'role' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // ১. ইউজার ডাটা আপডেট
            $user->name = $request->name;
            $user->email = $request->email;
            
            // পাসওয়ার্ড ইনপুট থাকলে আপডেট করবে
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // ২. রোল আপডেট (Spatie syncRoles)
            $user->role = $request->role;
            $user->syncRoles([$request->role]);
            $user->save();

            // ৩. এমপ্লয়ি ডাটা আপডেট
            $employee->update([
                'designation'    => $request->designation,
                'phone_personal' => $request->phone_personal,
                'address'        => $request->address,
                'joining_date'   => $request->joining_date,
                'salary'         => $request->salary,
                'status'         => $request->status ?? 'active',
            ]);

            DB::commit();
            return redirect()->route('super.employees.index')->with('success', 'Employee updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // --- ডিলিট মেথড ---
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $user = User::findOrFail($id);
            
            // এমপ্লয়ি ডাটা আগে ডিলিট হবে (Foreign key constraint থাকলে)
            Employee::where('user_id', $user->id)->delete();
            
            // ইউজার ডিলিট
            $user->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Employee deleted successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}