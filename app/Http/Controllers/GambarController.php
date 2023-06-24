<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use App\Http\Controllers\CloudinaryStorage;
// use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;


class GambarController extends Controller
{
    public function index()
    {
        $data = gambar::all();
        return response()->json(["message" => $data]);
    }

    public function store(Request $request)
    {
        $image  = $request->file('gambar');
        $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
        gambar::create(["gambar" => $result]);
        return response()->json(["message" => "Success,terbuat"]);
    }

    public function update(Request $request, $id)
    {
        $gambar = gambar::where('id', $id)->first();

        $file   = $request->file('gambar');

        $result = CloudinaryStorage::replace($gambar->gambar, $file->getRealPath(), $file->getClientOriginalName());
        $gambar->update([
            'gambar' => $result
        ]);
        return response()->json(["message" => "Success", "data" => $result]);
    }


    public function delete($id)
    {
        $gambar = gambar::find($id);
        CloudinaryStorage::delete($gambar->gambar);
        $gambar->delete();
        return response()->json(["message" => "Success,terhapus"]);
    }
}
