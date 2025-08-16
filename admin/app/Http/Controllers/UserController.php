<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>['required','string'],
            'phone' => ['required','regex:/^09[0|1|2|3][0-9]{8}$/','unique:users,phone'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','min:5']
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password

        ]);

        return redirect()->route('users.index')->with('success','کاربر با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' =>['required','string'],
            'phone' => ['required','regex:/^09[0|1|2|3][0-9]{8}$/','unique:users,phone,'.$user->id],
            'email' => ['required','email','unique:users,email,'.$user->id],
            'password' => ['required','min:5']
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->has('password') ? Hash::make($request->password) : $user->password

        ]);

        return redirect()->route('users.index')->with('success','کاربر با موفقیت ویرایش  شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
