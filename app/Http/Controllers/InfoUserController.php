<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class InfoUserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all();
        $departments = Department::all();
        $staffs= Staff::all();
        return view('user.create', ['faculties' => $faculties, 'departments' => $departments, 'staffs' => $staffs]);
    }
    public function edit($id)
    {
        $user = User::find($id);
        $faculties = Faculty::all();
        $departments = Department::all();
        $staffs = Staff::all();
        return view('user.edit', ['faculties' => $faculties, 'departments' => $departments, 'staffs' => $staffs,'user'=>$user]);
        //return view('laravel-examples/user-profile');
    }

    public function store(Request $request)
    {

        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
            'department_id'     => ['required', 'integer', 'exists:departments,id'],
            'staff_id' => ['required', 'integer', 'exists:staff,id'],
            'notes'    => ['max:150'],
            'role' => ['required']
        ]);
        if ($request->get('email') != Auth::user()->email) {

            $attribute = request()->validate([
                'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
            ]);
        }


        User::where('id', Auth::user()->id)
            ->update([
                'name'    => $attributes['name'],
                'email' => $attribute['email'],
                'phone'     => $attributes['phone'],
                'staff_id' => $attributes['staff_id'],
                'about_me'    => $attributes["notes"],
                'role' => $attributes["role"],
            ]);


        return redirect('/user-profile')->with('success', 'Profile updated successfully');
    }
    public function update(Request $request, $id)
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'department_id' => ['required', 'exists:departments,id'],
            'password' => ['required', 'min:5', 'max:20'],
            'staff_id' => ['required', 'integer', 'exists:staff,id'],
            'role' => ['required'],
            'notes' => ['nullable']
        ]);
        $attributes['password'] = bcrypt($attributes['password']);
        // Begin database transaction
        DB::beginTransaction();
        // dd($attributes);
        try {
            $e = User::create([
                'name'    => $attributes['name'],
                'email' => $attributes['email'],
                'password' => $attributes['password'],
                'department_id' => $attributes['department_id'],
                'staff_id' => $attributes['staff_id'],
                'role' => $attributes['role'],
                'about_me' => $attributes['notes'],
                'created_by' => Auth::user()->name,
            ]);
            DB::commit();
            return redirect('user')->with('success', 'Record Created Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating user record: ' . $e->getMessage());

            return redirect('user')->with('error', 'Failed to create record. Please try again.');
        }
    }
}
