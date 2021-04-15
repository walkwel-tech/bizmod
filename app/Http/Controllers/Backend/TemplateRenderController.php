<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\ImageController;
use Storage;
use setasign\Fpdi\Tcpdf\Fpdi;
//use App\Helpers\Custom_FPDF;

use App\Business;
use App\PdfTemplate;
use App\Code;
use Carbon\Carbon;

use App\Helpers\TemplateConfiguration;


use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;

class TemplateRenderController extends Controller
{

    public function renderDefault(Request $request, PdfTemplate $template)
    {
        $pathToTemplate = $template->path;

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile(Storage::disk('pdf')->path($pathToTemplate));

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);


            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            $pdf->useTemplate($templateId);
        }

        $pdf->Output();
    }

    public function renderCodeDigital(Request $request,   $code)
    {


        $codeObj = Code::where('code', $code)->first();
        //$pdfData = $this->getPdfData($codeObj);

        $businessData = $codeObj->digital_template->configuration->business;
        $codeData = $codeObj->digital_template->configuration->code;
        $expireData = $codeObj->digital_template->configuration->expire;
        $expireDate = (new Carbon($codeObj->expire_on))->format("d-m-Y");

        $businessColor = static::hex2rgb($businessData['text']['color']);
        $codeColor = static::hex2rgb($codeData['text']['color']);
        $expireColor = static::hex2rgb($expireData['text']['color']);

        $pathToTemplate = $codeObj->digital_template->path ?? 'default.pdf';

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile(Storage::disk('pdf')->path($pathToTemplate));

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);


            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            $pdf->useTemplate($templateId);

            if ($pageNo == 1) {

                $pdf->SetFont('', 'B', $businessData['text']['size']);
                $pdf->SetFontSpacing($businessData['text']['spacing']);
                $pdf->SetTextColor($businessColor['r'], $businessColor['g'], $businessColor['b']);
                $pdf->writeHTMLCell(0, 0, $businessData['position']['x'], $businessData['position']['y'], $codeObj->business->title, 0, 1, 0, true, 'C', false);

                $pdf->SetFont('', 'B', $codeData['text']['size']);
                $pdf->SetFontSpacing($codeData['text']['spacing']);
                $pdf->SetTextColor($codeColor['r'], $codeColor['g'], $codeColor['b']);
                $pdf->writeHTMLCell(0, 0, $codeData['position']['x'], $codeData['position']['y'],  $codeObj->code, 0, 1, 0, true, 'C', false);
            }
            if ($pageNo == 2) {
                $pdf->SetAutoPageBreak('auto',0);
                $pdf->SetFont('', 'B', $expireData['text']['size']);
                $pdf->SetFontSpacing($expireData['text']['spacing']);
                $pdf->SetTextColor($expireColor['r'], $expireColor['g'], $expireColor['b']);
                $pdf->writeHTMLCell(0, 0, $expireData['position']['x'], $expireData['position']['y'] , $expireDate, 0, true, '', false);


            }
        }

        $pdf->Output();
    }

    public function renderCodePrint(Request $request,   $code)
    {


        $codeObj = Code::where('code', $code)->first();
        //$pdfData = $this->getPdfData($codeObj);

        $businessData = $codeObj->print_ready_template->configuration->business;
        $codeData = $codeObj->print_ready_template->configuration->code;
        $expireData = $codeObj->print_ready_template->configuration->expire;
        $expireDate = (new Carbon($codeObj->expire_on))->format("d-m-Y");

        $businessColor = static::hex2rgb($businessData['text']['color']);
        $codeColor = static::hex2rgb($codeData['text']['color']);
        $expireColor = static::hex2rgb($expireData['text']['color']);

        $pathToTemplate = $codeObj->print_ready_template->path ?? 'default.pdf';

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile(Storage::disk('pdf')->path($pathToTemplate));

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);


            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            $pdf->useTemplate($templateId);

            if ($pageNo == 1) {

                $pdf->SetFont('', 'B', $businessData['text']['size']);
                $pdf->SetFontSpacing($businessData['text']['spacing']);
                $pdf->SetTextColor($businessColor['r'], $businessColor['g'], $businessColor['b']);
                $pdf->writeHTMLCell(0, 0, $businessData['position']['x'], $businessData['position']['y'], $codeObj->business->title, 0, 1, 0, true, 'C', false);

                $pdf->SetFont('', 'B', $codeData['text']['size']);
                $pdf->SetFontSpacing($codeData['text']['spacing']);
                $pdf->SetTextColor($codeColor['r'], $codeColor['g'], $codeColor['b']);
                $pdf->writeHTMLCell(0, 0, $codeData['position']['x'], $codeData['position']['y'],  $codeObj->code, 0, 1, 0, true, 'C', false);
            }
            if ($pageNo == 2) {
                $pdf->SetAutoPageBreak('auto',0);
                $pdf->SetFont('', 'B', $expireData['text']['size']);
                $pdf->SetFontSpacing($expireData['text']['spacing']);
                $pdf->SetTextColor($expireColor['r'], $expireColor['g'], $expireColor['b']);
                $pdf->writeHTMLCell(0, 0, $expireData['position']['x'], $expireData['position']['y'] , $expireDate, 0, true, '', false);


            }
        }

        $pdf->Output();
    }

    public function renderBatch(Request $request)
    {

        $batch_no = $request->input('batch_no');
        $codeObjects = Code::where('batch_no', '=', $batch_no)->get();
        //$pdf = new Custom_FPDF();
        $count = 0;
        foreach ($codeObjects as $key => $codeObj) {


            if ($count == 0) {
                $pdf = new Fpdi();
                $start = $key + 1;
            }
            $businessData = $codeObj->print_ready_template->configuration->business;
            $codeData = $codeObj->print_ready_template->configuration->code;
            $expireData = $codeObj->print_ready_template->configuration->expire;
            $expireDate = (new Carbon($codeObj->expire_on))->format("d-m-Y");

            $businessColor = static::hex2rgb($businessData['text']['color']);
            $codeColor = static::hex2rgb($codeData['text']['color']);
            $expireColor = static::hex2rgb($expireData['text']['color']);

            $pathToTemplate = $codeObj->print_ready_template->path ?? 'default.pdf';

            $pageCount = $pdf->setSourceFile(Storage::disk('pdf')->path($pathToTemplate));

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);


                if ($size['width'] > $size['height']) {
                    $pdf->AddPage('L', array($size['width'], $size['height']));
                } else {
                    $pdf->AddPage('P', array($size['width'], $size['height']));
                }

                $pdf->useTemplate($templateId);

                if ($pageNo == 1) {

                    $pdf->SetFont('', 'B', $businessData['text']['size']);
                    $pdf->SetFontSpacing($businessData['text']['spacing']);
                    $pdf->SetTextColor($businessColor['r'], $businessColor['g'], $businessColor['b']);
                    $pdf->writeHTMLCell(0, 0, $businessData['position']['x'], $businessData['position']['y'], $codeObj->business->title, 0, 1, 0, true, 'C', false);

                    $pdf->SetFont('', 'B', $codeData['text']['size']);
                    $pdf->SetFontSpacing($codeData['text']['spacing']);
                    $pdf->SetTextColor($codeColor['r'], $codeColor['g'], $codeColor['b']);
                    $pdf->writeHTMLCell(0, 0, $codeData['position']['x'], $codeData['position']['y'],  $codeObj->code, 0, 1, 0, true, 'C', false);
                }
                if ($pageNo == 2) {
                    $pdf->SetAutoPageBreak('auto',0);
                    $pdf->SetFont('', 'B', $expireData['text']['size']);
                    $pdf->SetFontSpacing($expireData['text']['spacing']);
                    $pdf->SetTextColor($expireColor['r'], $expireColor['g'], $expireColor['b']);
                    $pdf->writeHTMLCell(0, 0, $expireData['position']['x'], $expireData['position']['y'] , $expireDate, 0, true, '', false);


                }

                $count++;
            }
            if ($count >= 100 || count($codeObjects) == $key + 1) {
                $end = $key + 1;
                $pathToUpload = Storage::disk()->path('batch_pdf');
                if (!Storage::exists($pathToUpload)) {
                    Storage::makeDirectory('batch_pdf');
                }
                $batchFileName = 'Batch-' . $codeObj->batch_no . '-Code-' . $start . '-' . $end . '.pdf';
                $pdf->Output($pathToUpload . '/' . $batchFileName , 'F');
                $count = 0;
            }
        }



        $zip_file = 'Batch-' . $codeObj->batch_no.'.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $path =  Storage::disk()->path('batch_pdf');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file) {

            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();

                $relativePath = 'Batch-' . $codeObj->batch_no . substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        foreach ($files as $name => $file) {
            //dd($name);
            if ($file->isFile()) {
                unlink($name);
            }
        }

        return response()->download($zip_file)->deleteFileAfterSend(true);
    }

    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'templates';
    }

    public static function getModelName()
    {
        return 'PdfTemplate';
    }

    public static function hex2rgb($colour)
    {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array('r' => $r, 'g' => $g, 'b' => $b);
    }
}
