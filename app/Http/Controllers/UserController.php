<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role == 'user') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses Ditolak ');
        }
        $users = DB::table('users')
            ->select('id', 'name', 'email', 'role', 'image', 'isActive')
            ->whereNull('deleted_at') 
            ->orderBy('id')
            ->get();

        return view('user.user_view')->with(compact('users'));;
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id); // Find the record by ID

        // Update the isActive field to 1
        $user->isActive = 1;

        // Save the changes to the database
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->isActive = 0;
            $user->save();
            $user->delete();
        }
    }
}
