<?php

namespace App\Http\Controllers;

use App\Models\EMCBayar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function laporan($startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate)->toDateString();
        $endDate = Carbon::parse($endDate)->toDateString();

        $bayar = EMCBayar::whereBetween('tgl_bayar', [$startDate, $endDate])->get();

        if ($bayar != null) {

        } else {
            $result = array(
                "status" => 400,
                "message" => "Laporan tidak ditemukan",
            );
            return response()->json($result, $result['status']);
        }
        // dd($bayar);


        // return view('struk.laporan', compact('bayar'));

        $pdf = Pdf::loadView('struk.laporan', compact('bayar'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Laporan Pembayaran.pdf');
    }
}
