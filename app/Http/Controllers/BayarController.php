<?php

namespace App\Http\Controllers;

use App\Models\EMCBayar;
use Illuminate\Http\Request;

class BayarController extends Controller
{
    //

    public function getData()
    {
        try {
            $area = EMCBayar::all();

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
                'tgl_bayar' => 'nullable|date',
                'tgl_muat' => 'nullable|date',
                'tgl_bongkar' => 'nullable|date',
                'no_lambung' => 'nullable|string|max:15',
                'area' => 'nullable|string|max:50',
                'harga' => 'required|numeric|min:0',
                'tonase' => 'nullable|string|max:11',
                'potongan1' => 'nullable|numeric|min:0',
                'potongan2' => 'nullable|numeric|min:0',
                'status' => 'nullable|integer',
            ]);


            $randomNumber = rand(1, 9999);
            $randomLetter = chr(rand(65, 90));

            $randomString = $randomLetter . $randomNumber;

            $area = EMCBayar::create([
                'nmr_struk' => substr(date('Y'), -2).date('m').date('d')."414T".$randomString,
                'tgl_bayar' => $request->tgl_bayar,
                'tgl_muat' => $request->tgl_muat,
                'tgl_bongkar' => $request->tgl_bongkar,
                'no_lambung' => $request->no_lambung,
                'area' => $request->area,
                'harga' => $request->harga,
                'tonase' => $request->tonase,
                'potongan1' => $request->potongan1,
                'potongan2' => $request->potongan2,
                'status' => $request->status,
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
