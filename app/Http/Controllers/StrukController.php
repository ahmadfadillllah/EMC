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
        $data = EMCBayar::where('nmr_struk', $nmr_struk)->first();

        // dd($data);

        return view('struk.invoice', $data);

        $pdf = Pdf::loadView('struk.invoice', $data);
        return $pdf->download('invoice.pdf');
    }
}
