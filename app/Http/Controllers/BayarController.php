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

    public function getFilter($nmr_struk)
    {
        try {
            if ($nmr_struk != '') {
                $pembayaran = EMCBayar::where('nmr_struk', 'LIKE', '%' . $nmr_struk . '%')->get();

                if (!$pembayaran->isEmpty()) {
                    $transStatus = true;
                    $transMessage = "Pembayaran ditemukan";
                } else {
                    $transStatus = false;
                    $transMessage = "Pembayaran tidak ditemukan";
                }
            } else {
                $pembayaran = EMCBayar::all();
                $transStatus = true;
                $transMessage = "Semua pembayaran ditampilkan";
            }


        } catch (\Throwable $th) {
            $transStatus = false;
            $transMessage = $th->getMessage();
        }

        if ($transStatus != false) {
            $result = array(
                "data" => $pembayaran,
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
             // Atau bisa disesuaikan sesuai kebutuhan

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
                'potongan_dll' => $request->potongan_dll,
                'status' => $request->status,
            ]);
            $data = DB::table('emc_bayar as bayar')
                ->leftJoin('emc_unit as unit', 'bayar.no_lambung', '=', 'unit.no_lambung')
                ->leftJoin('emc_area as area', 'bayar.area', '=', 'area.area')
                ->select(
                    'bayar.nmr_struk',
                    'bayar.tgl_bayar',
                    'bayar.no_lambung',
                    'unit.no_polisi',
                    'unit.driver',
                    'area.area',
                    'bayar.tonase',
                    'bayar.harga',
                    DB::raw('COALESCE(bayar.tonase, 0) * COALESCE(bayar.harga, 0) as total_bayar'),
                    'bayar.potongan1',
                    'bayar.potongan2',
                    'bayar.potongan_dll',
                    DB::raw('COALESCE(bayar.tonase, 0) * COALESCE(bayar.harga, 0) - COALESCE(bayar.potongan1, 0) - COALESCE(bayar.potongan2, 0) - COALESCE(bayar.potongan_dll, 0) as jumlah_bayar'),
                    'unit.no_rekening'
                )
                ->where('bayar.nmr_struk', '=', $request->nmr_struk)
                ->first();

            $totalBayar = ($request->tonase * $request->harga) - ($request->potongan1 + $request->potongan2 + $request->potongan_dll);
            $jumlahBayar = $totalBayar;

            $bayar->setAttribute('totalBayar', $totalBayar);
            $bayar->setAttribute('jumlahBayar', $jumlahBayar);
            $bayar->setAttribute('no_polisi', $data->no_polisi);
            $bayar->setAttribute('driver', $data->driver);

            $transStatus = true;
            $transMessage = "Berhasil menambahkan pembayaran";

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
                    'bayar.no_lambung',
                    'bayar.tgl_bayar',
                    'unit.no_polisi',
                    'unit.driver',
                    'area.area',
                    'bayar.tonase',
                    DB::raw('COALESCE(bayar.tonase, 0) * COALESCE(bayar.harga, 0) as total_bayar'),
                    'bayar.potongan1',
                    'bayar.potongan2',
                    'bayar.potongan_dll',
                    DB::raw('COALESCE(bayar.tonase, 0) * COALESCE(bayar.harga, 0) - COALESCE(bayar.potongan1, 0) - COALESCE(bayar.potongan2, 0) - COALESCE(bayar.potongan_dll, 0) as jumlah_bayar'),
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
