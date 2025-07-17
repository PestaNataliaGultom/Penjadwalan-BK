<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereHas('roles', function($q){
            $q->where('name', 'Guru Bk');
        })->get();
        return view('admin.guru.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.guru.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try {
            $users = User::create([
                'name' => $request->nama, 
                'email' => $request->email, 
                'nip' => $request->nip, 
                'capacity' => $request->capacity, 
                'jabatan' => $request->jabatan, 
                'alamat' => $request->alamat, 
                'nomor_handphone' => $request->no_hp,
                'password' => bcrypt($request->password),
                'is_active' => true
            ]);
            $users->assignRole('Guru Bk');
            return redirect()->route('guru.index')->with('success', 'Data Berhasil ditambahkan');
       } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Data Error');
       }
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
        $user = User::find($id);
        return view('admin.guru.edit', compact('user'));
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::find($id);

            if(!$user){
                return redirect()->route('guru.index')->with('error', 'Data Not Found');
            }

              $user->update([
                'name' => $request->nama, 
                'email' => $request->email, 
                'nip' => $request->nip, 
                'jabatan' => $request->jabatan, 
                'capacity' => $request->capacity, 
                'alamat' => $request->alamat, 
                'nomor_handphone' => $request->no_hp,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'is_active' => true
            ]);

            return redirect()->route('guru.index')->with('success', 'Data Berhasil Diupdate');
       } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Error');
       }
      //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);

            if(!$user){
                return redirect()->route('guru.index')->with('error', 'Data Not Found');
            }

            $user->delete();

            return redirect()->route('guru.index')->with('success', 'Data Berhasil dihapus');
       } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Error');
       }
    }
}
