<?php

namespace App\Http\Controllers;

use App\Models\EMCBayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BayarController extends Controller
{
    //

    public function getData()
    {
        try {
            $bayar = EMCBayar::all();

            $transStatus = true;
            $transMessage = "Success";

        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        if ($transStatus != false) {
            $result = array(
                "data" => $bayar,
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
                'nmr_struk' => 'nullable|string|max:150',
                'tgl_bayar' => 'nullable|date',
                'tgl_muat' => 'nullable|date',
                'tgl_bongkar' => 'nullable|date',
                'no_lambung' => 'nullable|string|max:15',
                'area' => 'nullable|string|max:50',
                'harga' => 'required|numeric|min:0',
                'tonase' => 'nullable|string|max:11',
                'potongan1' => 'nullable|numeric|min:0',
                'potongan2' => 'nullable|numeric|min:0',
                'potongan_dll' => 'nullable|numeric|min:0',
                'status' => 'nullable|integer',
            ]);


            $randomNumber = rand(1, 9999);
            $randomLetter = chr(rand(65, 90));

            $randomString = $randomLetter . $randomNumber;

            $bayar = EMCBayar::create([
                // 'nmr_struk' => substr(date('Y'), -2).date('m').date('d')."414T".$randomString,
                'nmr_struk' => $request->nmr_struk,
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
                "data" => $bayar,
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

    public function updateData(Request $request, $id_bayar)
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
                'potongan_dll' => 'nullable|numeric|min:0',
                'status' => 'nullable|integer',
            ]);

            // Mencari data berdasarkan ID
            $bayar = EMCBayar::where('id_bayar', $id_bayar)->first();

            // Jika data tidak ditemukan, kembalikan response error
            if (!$bayar) {
                $transStatus = false;
                $transMessage = "Data dengan ID " . $id_bayar . " tidak ditemukan";
            } else {

                EMCBayar::where('id_bayar', $id_bayar)->update([
                    'tgl_bayar' => $request->tgl_bayar,
                    'tgl_muat' => $request->tgl_muat,
                    'tgl_bongkar' => $request->tgl_bongkar,
                    'no_lambung' => $request->no_lambung,
                    'area' => $request->area,
                    'harga' => $request->harga,
                    'tonase' => $request->tonase,
                    'potongan1' => $request->potongan1,
                    'potongan2' => $request->potongan2,
                    'potongan_dll' => $request->potongan_dll,
                    'status' => $request->status,
                ]);

                $transStatus = true;
                $transMessage = "Berhasil memperbarui pembayaran";
            }

        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        // Menyusun response
        if ($transStatus != false) {
            $result = array(
                "data" => $bayar,
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

    public function previewData($nmr_struk)
    {

        try {

            $bayar = DB::table('emc_bayar as bayar')
                ->leftJoin('emc_unit as unit', 'bayar.no_lambung', '=', 'unit.no_lambung')
                ->leftJoin('emc_area as area', 'bayar.area', '=', 'area.area')
                ->select(
                    'bayar.nmr_struk',
                    'bayar.tgl_bayar',
                    'unit.no_polisi',
                    'unit.driver',
                    'area.area',
                    'bayar.tonase',
                    'bayar.harga as total_bayar',
                    'bayar.potongan1',
                    'bayar.potongan2',
                    'bayar.potongan_dll',
                    DB::raw('bayar.harga - bayar.potongan1 - bayar.potongan2 - bayar.potongan_dll as jumlah_bayar'),
                    'unit.no_rekening'
                )
                ->where('bayar.nmr_struk', '=', $nmr_struk)
                ->first();

            // Jika data berhasil ditemukan, set status dan message
            if ($bayar) {
                $transStatus = true;
                $transMessage = "Pembayaran ditemukan";
            } else {
                // Jika tidak ada data, set status gagal
                $transStatus = false;
                $transMessage = "Pembayaran tidak ditemukan";
            }
        } catch (\Throwable $th) {
            // Jika ada error dalam query atau proses, handle error dengan false status
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        // Menyusun response
        if ($transStatus) {
            $result = [
                "data" => $bayar,
                "status" => 201,
                "message" => $transMessage,
            ];
        } else {
            $result = [
                "status" => 400,
                "message" => $transMessage,
            ];
        }

        return response()->json($result, $result['status']);

    }

    public function deleteData($id_bayar)
    {
        try {
            // Mencari data berdasarkan ID
            $bayar = EMCBayar::where('id_bayar', $id_bayar)->first();

            // Jika data tidak ditemukan, kembalikan response error
            if (!$bayar) {
                $transStatus = false;
                $transMessage = "Data dengan ID " . $id_bayar . " tidak ditemukan";
            } else {
                // Menghapus data
                $bayar->delete();

                $transStatus = true;
                $transMessage = "Berhasil menghapus pembayaran";
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
