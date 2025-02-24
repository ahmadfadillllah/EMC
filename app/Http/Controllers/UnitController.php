<?php

namespace App\Http\Controllers;

use App\Models\EMCUnit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    //
    public function getData()
    {
        try {
            $unit = EMCUnit::all();

            $transStatus = true;
            $transMessage = "Success";

        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        if ($transStatus != false) {
            $result = array(
                "data" => $unit,
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

    public function getFilter($no_lambung)
    {
        try {
            if ($no_lambung != '') {
                $unit = EMCUnit::where('no_lambung', 'LIKE', '%' . $no_lambung . '%')->get();

                if (!$unit->isEmpty()) {
                    $transStatus = true;
                    $transMessage = "Unit ditemukan";
                } else {
                    $transStatus = false;
                    $transMessage = "Unit tidak ditemukan";
                }
            } else {
                $unit = EMCUnit::all();
                $transStatus = true;
                $transMessage = "Semua unit ditampilkan";
            }


        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        if ($transStatus != false) {
            $result = array(
                "data" => $unit,
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
                'no_lambung' => 'required|string|max:15|unique:emc_unit,no_lambung',
                'no_polisi' => 'nullable|string|max:15',
                'no_ktp' => 'nullable|string|max:20',
                'driver' => 'nullable|string|max:50',
                'no_tlp' => 'nullable|string|max:20',
                'no_rekening' => 'nullable|string|max:30',
            ]);


            $unit = EMCUnit::create([
                'no_lambung' => $request->no_lambung,
                'no_polisi' => $request->no_polisi,
                'no_ktp' => $request->no_ktp,
                'driver' => $request->driver,
                'no_tlp' => $request->no_tlp,
                'no_rekening' => $request->no_rekening,
            ]);

            $transStatus = true;
            $transMessage = "Berhasil menambahkan unit";

        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        if ($transStatus != false) {
            $result = array(
                "data" => $unit,
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

    public function updateData(Request $request, $id_unit)
    {
        try {
            // Menambahkan validasi pada request
            $request->validate([
                'no_polisi' => 'nullable|string|max:15',
                'no_ktp' => 'nullable|string|max:20',
                'driver' => 'nullable|string|max:50',
                'no_tlp' => 'nullable|string|max:20',
                'no_rekening' => 'nullable|string|max:30',
            ]);

            // Mencari data berdasarkan ID
            $unit = EMCUnit::where('id_unit', $id_unit)->first();

            // Jika data tidak ditemukan, kembalikan response error
            if (!$unit) {
                $transStatus = false;
                $transMessage = "Data dengan ID " . $id_unit . " tidak ditemukan";
            } else {

                EMCUnit::where('id_unit', $id_unit)->update([
                    'no_polisi' => $request->no_polisi,
                    'no_ktp' => $request->no_ktp,
                    'driver' => $request->driver,
                    'no_tlp' => $request->no_tlp,
                    'no_rekening' => $request->no_rekening,
                ]);

                $transStatus = true;
                $transMessage = "Berhasil memperbarui unit";
            }

        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        // Menyusun response
        if ($transStatus != false) {
            $result = array(
                "data" => $unit,
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

    public function deleteData($id_unit)
    {
        try {
            // Mencari data berdasarkan ID
            $unit = EMCUnit::where('id_unit', $id_unit)->first();

            // Jika data tidak ditemukan, kembalikan response error
            if (!$unit) {
                $transStatus = false;
                $transMessage = "Data dengan ID " . $id_unit . " tidak ditemukan";
            } else {
                // Menghapus data
                $unit->delete();

                $transStatus = true;
                $transMessage = "Berhasil menghapus unit";
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
