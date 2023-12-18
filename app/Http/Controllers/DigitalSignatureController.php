<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;
use TCPDF;
use setasign\Fpdi\Tcpdf\Fpdi;

class DigitalSignatureController extends Controller
{
    public function downloadPdf(Request $request){
        $cipher = "AES-256-CBC";
        $options = 0;
        $iv = str_repeat("0", openssl_cipher_iv_length($cipher));
        $decryptedEmail = openssl_decrypt(Auth::user()->email, $cipher, Auth::user()->keyAES, $options, $iv);
        $username = Auth::user()->username;

        $certificate = 'file://'.base_path().'/storage/app/certificates/Webhub.crt';
        // $certificate = base_path("/storage/app/certificates/{$username}.crt");

        // signature information
        $info = array(
            'Name' => Auth::user()->username,
            'Location' => 'Indonesia',
            'Reason' => 'Generate Digitally Signed PDF',
            'ContactInfo' => $decryptedEmail,
        );

        $request->validate([
            'file' => 'required|file|mimes:pdf',
        ]);
        $file = $request->file('file');
        Log::info('Processing file: ' . $file->getClientOriginalName());


        $pdf = new Fpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage();

        // Set signature
        $pdf->setSignature($certificate, $certificate, 'PDFSecurity', '', 2, $info);
        // Add content to the PDF
        $pdf->setSourceFile($file->getRealPath());
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 10, 10, 200, 200);

        // Output the PDF
        $pdf->Output(public_path($file->getClientOriginalName().'-digitally-signed.pdf'), 'D');
    }
}
