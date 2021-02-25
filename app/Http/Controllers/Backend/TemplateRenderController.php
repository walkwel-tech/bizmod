<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\ImageController;
use Storage;
use App\Helpers\Custom_FPDF;

use App\Business;
use App\PdfTemplate;
use App\Code;

use App\Helpers\TemplateConfiguration;


use Spatie\QueryBuilder\QueryBuilder;

use Illuminate\Http\Request;

class TemplateRenderController extends Controller
{

    public function renderDefault(Request $request, PdfTemplate $template)
    {
        $pathToTemplate = $template->path;

        $pdf = new Custom_FPDF();
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

    public function renderCode(Request $request,   $code)
    {


        $codeObj = Code::where('code', $code)->first();
        //$pdfData = $this->getPdfData($codeObj);

        $businessData = $codeObj->template->configuration->business;
        $codeData = $codeObj->template->configuration->code;

        $businessColor = static::hex2rgb($businessData['text']['color']);
        $codeColor = static::hex2rgb($codeData['text']['color']);

        $pathToTemplate = $codeObj->template->path ?? 'default.pdf';

        $pdf = new Custom_FPDF();
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
                $pdf->SetFont('Arial', 'B', $businessData['text']['size']);
                $pdf->SetFontSpacing($businessData['text']['spacing']);
                $pdf->SetTextColor($businessColor['r'], $businessColor['g'], $businessColor['b']);
                $pdf->SetXY($businessData['position']['x'], $businessData['position']['y']);
                $pdf->Cell(0, 0, $codeObj->business->title, 0, 0, '');
                $pdf->SetFont('Arial', 'B', $codeData['text']['size']);
                $pdf->SetFontSpacing($codeData['text']['spacing']);
                $pdf->SetTextColor($codeColor['r'], $codeColor['g'], $codeColor['b']);
                $pdf->SetXY($codeData['position']['x'], $codeData['position']['y']);
                $pdf->Cell(0, 0, $codeObj->code, 0, 0, '');

                // $pdf->SetFont('Arial', 'B', 20);

                // $pdf->SetTextColor(0,0,0);
                // $pdf->SetXY(85, 20);
                // $pdf->SetFontSpacing(10);
                // $space = $pdf->GetStringWidth('b_title');
                // // dd($space);
                // $pdf->Cell(0, 0, 'btitle', 0, 0, '');
                // //$pdf->MultiCell(0, 10, 'b_title', 1, 'C',false);
                // $pdf->SetFont('Arial', 'B', 20);
                // $pdf->SetFontSpacing(15);
                // $pdf->SetTextColor(0,0,0);
                // $pdf->SetXY(85, 180);
                // $pdf->Cell(0, 0, 'code', 0, 0, '');
            }
        }

        $pdf->Output();
    }


    protected static function requiresPermission()
    {
        return true;
    }

    protected static function getPermissionKey()
    {
        return 'pdf_templates';
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
