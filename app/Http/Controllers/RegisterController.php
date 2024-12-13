<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }


    public function store()
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
