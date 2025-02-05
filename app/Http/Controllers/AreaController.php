<?php

namespace App\Http\Controllers;

use App\Models\EMCArea;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    //

    public function getData()
    {
        try {
            $area = EMCArea::all();

            $transStatus = true;
            $transMessage = "Success";

        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        if ($transStatus != false) {
            $result = array(
                "data" => $area,
                "status" => 201,
                "message" => $transMessage,
            );
        } else {
            $result = array(
                "status" => 400,
                "message" => $transMessage,
            );
        }
        return response()->json($result, $result['status']);
    }

    public function postData(Request $request)
    {
        try {
            // Menambahkan validasi pada request
            $request->validate([
                'area' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
            ]);


            $area = EMCArea::create([
                'area' => $request->area,
                'harga' => $request->harga,
            ]);

            $transStatus = true;
            $transMessage = "Berhasil menambahkan area";

        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        if ($transStatus != false) {
            $result = array(
                "data" => $area,
                "status" => 201,
                "message" => $transMessage,
            );
        } else {
            $result = array(
                "status" => 400,
                "message" => $transMessage,
            );
        }
        return response()->json($result, $result['status']);
    }

    public function updateData(Request $request, $id_area)
    {
        try {
            // Menambahkan validasi pada request
            $request->validate([
                // 'area' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
            ]);

            // Mencari data berdasarkan ID
            $area = EMCArea::where('id_area', $id_area)->first();

            // Jika data tidak ditemukan, kembalikan response error
            if (!$area) {
                $transStatus = false;
                $transMessage = "Data dengan ID " . $id_area . " tidak ditemukan";
            } else {

                EMCArea::where('id_area', $id_area)->update([
                    'harga' => $request->harga,
                ]);

                $transStatus = true;
                $transMessage = "Berhasil memperbarui area";
            }

        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        // Menyusun response
        if ($transStatus != false) {
            $result = array(
                "data" => $area,
                "status" => 200,
                "message" => $transMessage,
            );
        } else {
            $result = array(
                "status" => 400,
                "message" => $transMessage,
            );
        }

        return response()->json($result, $result['status']);
    }

    public function deleteData($id_area)
    {
        try {
            // Mencari data berdasarkan ID
            $area = EMCArea::where('id_area', $id_area)->first();

            // Jika data tidak ditemukan, kembalikan response error
            if (!$area) {
                $transStatus = false;
                $transMessage = "Data dengan ID " . $id_area . " tidak ditemukan";
            } else {
                // Menghapus data
                $area->delete();

                $transStatus = true;
                $transMessage = "Berhasil menghapus area";
            }

        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        // Menyusun response
        if ($transStatus != false) {
            $result = array(
                "status" => 201,
                "message" => $transMessage,
            );
        } else {
            $result = array(
                "status" => 400,
                "message" => $transMessage,
            );
        }

        return response()->json($result, $result['status']);
    }


}
