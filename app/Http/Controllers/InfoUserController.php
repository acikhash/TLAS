<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function edit()
    {
        return view('laravel-examples/user-profile');
    }

    public function store(Request $request)
    {

        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
            'phone'     => ['max:50'],
            'staff_id' => ['required', 'integer', 'exists:staff,id'],
            'about_me'    => ['max:150'],
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
                'about_me'    => $attributes["about_me"],
                'role' => $attributes["role"],
            ]);


        return redirect('/user-profile')->with('success', 'Profile updated successfully');
    }
}
