<?php

namespace App\Http\Controllers;

use App\Models\EMCBayar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class StrukController extends Controller
{
    //
    public function invoice($nmr_struk)
    {

        $bayar = DB::table('emc_bayar as bayar')
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
                    DB::raw('COALESCE(bayar.tonase, 0) * COALESCE(bayar.harga, 0) as total_bayar'),
                    'bayar.potongan1',
                    'bayar.potongan2',
                    'bayar.potongan_dll',
                    DB::raw('COALESCE(bayar.tonase, 0) * COALESCE(bayar.harga, 0) - COALESCE(bayar.potongan1, 0) - COALESCE(bayar.potongan2, 0) - COALESCE(bayar.potongan_dll, 0) as jumlah_bayar'),
                    'unit.no_rekening'
                )
                ->where('bayar.nmr_struk', '=', $nmr_struk)
                ->first();


        if ($bayar != null) {

        } else {
            $result = array(
                "status" => 400,
                "message" => "Struk tidak ditemukan",
            );
            return response()->json($result, $result['status']);
        }

        // return view('struk.index', compact('bayar'));

        $pdf = Pdf::loadView('struk.index', compact('bayar'));
        // $pdf->setPaper('A5', 'portrait');
        return $pdf->download('Struk.pdf');



    }
}
