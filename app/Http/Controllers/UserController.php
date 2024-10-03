<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function user(Request $request){

        $data = new User;

        if($request->get('usersearch')){
            $data = $data->where('name','LIKE','%'.$request->get('usersearch').'%')
            ->orWhere('username','LIKE','%'.$request->get('usersearch').'%');
        }
        $data = $data->get();

        return view('user.index',compact('data','request'));

    }

    public function create(){
        $hasRole = auth()->user()->getRoleNames();
        return view('user.create', compact('hasRole'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'image'     => 'required|mimes:png,jpg,jpeg|max:2048',
            'nama'      => 'required',
            'username'  => 'required',
            'password'  => 'required',
            'role'      => 'required|in:Manager,Kasir,Anggota,Admin',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $image      = $request->file('image');
        $filename   = date('Y-m-d') . '-' . $image->getClientOriginalName();
        $path       = 'photo-user/'. $filename;
        Storage::disk('public')->put($path, file_get_contents($image));

        $user = User::create([
            'username' => $request->username,
            'name' => $request->nama,
            'password' => Hash::make($request->password),
            'image' => $filename,
        ]);

        $user->assignRole($request->role);

        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.user');
    }

    public function edit($name) {
        $data = User::where('name', $name)->firstOrFail();
        $hasRole = auth()->user()->getRoleNames();

        return view('user.edit', compact('data', 'hasRole'));
    }

    public function update(Request $request, $name) {
        $user = User::where('name', $name)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'image'     => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'username'  => 'required',
            'nama'      => 'required',
            'role'      => 'required|in:Manager,Kasir,Anggota,Admin',
            'password'  => 'nullable',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $user->username = $request->username;
        $user->name     = $request->nama;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = date('Y-m-d') . '-' . $image->getClientOriginalName();
            $path = 'photo-user/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($image));

            if ($user->image) {
                Storage::disk('public')->delete('photo-user/' . $user->image);
            }

            $user->image = $filename;
        }

        // Sync roles using Spatie's method
        $user->syncRoles([$request->role]);

        $user->save();

        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.user');
    }

    public function delete($id){
        $data = User::find($id);

        if($data){
            $data->delete();
        }

        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.user');
    }
}
