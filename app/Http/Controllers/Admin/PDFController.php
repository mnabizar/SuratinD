<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function surat($id)
    {
        $surat = Surat::findOrFail($id);

        $pdf = Pdf::loadView('pdf.surat', compact('surat'));

        return $pdf->download('surat.pdf');
    }
}