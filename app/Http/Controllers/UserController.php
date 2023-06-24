<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();

        return response()->json(['data' => $user]);
    }

    public function read($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['massage' => 'user tidak ditemukan']);
        }

        return response()->json(['data' => $user]);
    }

    public function update(Request $request, $id)
    {
        $satu = auth('sanctum')->user();
        $levels = $satu->level;
        $dua = User::where('id', $id)->first();

        if ($dua) {
            if ($levels == 'admin') {
                $dua->update([
                    "username" => $request->username,
                    "gender" => $request->gender,
                    "umur" => $request->umur,
                    "email" => $request->email,
                    "alamat" => $request->alamat,
                ]);

                if ($request->has('password')) {
                    $dua->password = bcrypt($request->password);
                }

                $dua->save();

                return response()->json(["message" => "data berhasil diubah", $dua]);
            } else {
                return response()->json(["message" => "Data bukan milik anda, jangan sembarang merubah"]);
            }
        } else {
            return response()->json(["message" => "Data pengguna tidak ditemukan"]);
        }
    }

    public function delete($id)
    {
        $admin = auth('sanctum')->user();
        $adminRole = 'admin';

        if ($admin->role !== $adminRole)

            $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "Pengguna tidak ditemukan"]);
        }

        $user->delete();
        return response()->json(["message" => "Pengguna berhasil dihapus"]);
    }
}
