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




}
