<?php

namespace App\Http\Controllers;

use App\Models\EMCBayar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StrukController extends Controller
{
    //
    public function invoice($nmr_struk)
    {
        $bayar = EMCBayar::where('nmr_struk', $nmr_struk)->first();

        if ($bayar != null) {

        } else {
            $result = array(
                "status" => 400,
                "message" => "Struk tidak ditemukan",
            );
            return response()->json($result, $result['status']);
        }




        return view('struk.invoice', $bayar);

        $pdf = Pdf::loadView('struk.invoice', $data);
        return $pdf->download('invoice.pdf');
    }
}
