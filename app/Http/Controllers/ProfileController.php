<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = DB::table('users')
            ->select('id','nip', 'name', 'email', 'role','bagian','pangkat','jabatan', 'image')
            ->where('id', '=', Auth::user()->id)
            ->get();
        return view('profile.profile_view')->with(compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profile = DB::table('users')
            ->where('id', '=', $id)
            ->get();
        return view('profile.profile_edit_view')->with(compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        $validatedData = $request->validate([
            'nip' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'bagian' => ['required', 'string', 'max:255'],
            'pangkat' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            // foto
            'image' => 'image|file|max:2048|mimes:png,jpg,jpeg|dimensions:max_width=300,max_height=300',
            
        ]);

        
        if ($request->file('image')) {
            if ($user['image'] != 'user.png') {
                Storage::delete('public/images/' . $user['image']);
            }
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $request->file('image')->storeAs('public/images/', $fileName);
            $validatedData['image'] = $fileName;
        } else {
            $validatedData['image'] = $user['image'];
        }
       
        User::where('id', $id)->update($validatedData);
        return redirect()->route('profile.index')
        ->with('success', 'Berhasil Update Profile');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
