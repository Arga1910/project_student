<?php

namespace App\Http\Controllers;

use App\Models\profile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        $profile = User::where('id', $user->id)->get();
        return response()->json(["profile" => $profile]);
    }

    public function edit(Request $request)
    {
        $auth = auth('sanctum')->user();
        $userid = $auth->id;

        $user = User::find($userid);

        $user->update([
            'username' => $request->username,
            'gender' => $request->gender,
            'umur' => $request->umur,
            'email' => $request->email,
            'alamat' => $request->alamat
        ]);

        return response()->json(["message" => "Data berhasil diubah", "user" => $user]);
    }


    public function destroy()
    {
        $auth = auth('sanctum')->user();

        $userid = $auth->id;

        $user = User::find($userid);


        // ... kode untuk menghapus akun pengguna ...
        $user->delete();

        return response()->json([
            'message' => 'Akun pengguna berhasil dihapus',
        ]);
    }

    // public function unggahprofile(Request $request)
    // {
    //     $request->validate([
    //         'profile_picture' => 'required|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $user = Auth::id();

    //     $data = User::find($user)->update([
    //         'profile_picture' => $request->profile_picture,
    //     ]);

    //     $data->save();

    //     return response()->json(["message" => "success', 'Gambar profile berhasil diunggah", 'data' => $data]);
    // }

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
    public function show(profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(profile $profile)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, User $user)
    // {
    //     $user = $request->user();




    /**
     * Remove the specified resource from storage.
     */
    // public function delete(Request $request)
    // {
    //     $user = $request->user(); 
    //     $user->delete();

    //     return response()->json(["message" => "data berhasil dihapus"]);
    // }

    // public function edit(Request $request, $id)
    // {
    // $user = auth('sanctum')->user();
    // $user = User::find($id);
    // Pastikan hanya pengguna yang bersangkutan yang dapat mengubah data
    // if ($user === $token) {
    //     return response()->json([
    //         'message' => 'Data bukan milik anda,tidak boleh diubah',
    //     ], 403);
    // }

    // $validator = Validator::make($request->all(), [
    //     'username' => 'required|string|max:255',
    //     'gender' => 'required|in:L,P',
    //     'umur' => 'required|integer',
    //     'email' => [
    //         'required',
    //         'string',
    //         'email',
    //         Rule::unique('users')->ignore($user->id),
    //     ],
    //     'alamat' => 'required|string|max:255',
    //     'password' => 'nullable|string|min:8|confirmed',
    // ]);

    // if ($validator->fails()) {
    //     return response()->json(['errors' => $validator->errors()], 422);
    // // }
    // $user->update([
    //     'username' => $request->username,
    //     'gender' => $request->gender,
    //     'umur' => $request->umur,
    //     'email' => $request->email,
    //     'alamat' => $request->alamat
    // ]);


    // if ($request->filled('password')) {
    //     $user->password = bcrypt($request->password);
    // }

    // $user->save();

    //     return response()->json(["message" => "data berhasil diubah", "user" => $user,]);


    // }

}
