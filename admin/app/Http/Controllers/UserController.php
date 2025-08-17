<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->with('roles')->get();
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create',compact('roles'));
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
            'password' => ['required','min:5'],
            'role_ids' => ['required'],
            'role_ids.*' => ['required','exists:roles,id']
        ]);

        DB::beginTransaction();

        $user=User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password

        ]);

        $user->roles()->attach($request->role_ids);

        DB::commit();

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
        $roles = Role::all();
        return view('user.edit',compact('user','roles'));
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
            'password' => ['nullable','min:5'],
            'role_ids' => ['required'],
            'role_ids.*' => ['required','exists:roles,id']
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password !==null ? Hash::make($request->password) : $user->password

        ]);
        $user->roles()->sync($request->role_ids);

        return redirect()->route('users.index')->with('success','کاربر با موفقیت ویرایش  شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user -> delete();
        return redirect()->route('users.index')->with('success','کاربر با موفقیت حذف  شد');
    }
}
