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
            $area = EMCUnit::all();

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
                'no_lambung' => 'required|string|max:15|unique:emc_unit,no_lambung',
                'no_polisi' => 'nullable|string|max:15',
                'no_ktp' => 'nullable|string|max:20',
                'driver' => 'nullable|string|max:50',
                'no_tlp' => 'nullable|string|max:20',
                'no_rekening' => 'nullable|string|max:30',
            ]);


            $area = EMCUnit::create([
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
}
