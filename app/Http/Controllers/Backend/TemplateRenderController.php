<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\ImageController;
use Storage;
use setasign\Fpdi\Fpdi;

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

    public function renderCode(Request $request,   $code)
    {


        $codeObj = Code::where('code', $code)->first();
        $pdfData = $this->getPdfData($codeObj);

        $pathToTemplate = $codeObj->template->path ?? 'default.pdf';

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
                $pdf->SetFont('Arial', 'B', 20);
                $pdf->SetTextColor($pdfData['business']['color']['r'], $pdfData['business']['color']['g'], $pdfData['business']['color']['b']);
                $pdf->SetXY($pdfData['business']['x'], $pdfData['business']['y']);
                $pdf->Cell(0, 0, $codeObj->business->title, 0, 0, 'C');
                $pdf->SetTextColor($pdfData['code']['color']['r'], $pdfData['code']['color']['g'], $pdfData['code']['color']['b']);
                $pdf->SetXY($pdfData['code']['x'], $pdfData['code']['y']);
                $pdf->Cell(0, 0, $codeObj->code, 0, 0, 'C');
            }
        }

        $pdf->Output();
    }

    public  function getPdfData (Code $codeObj)
    {

        $data = array();
        $color = $codeObj->template->configuration->getBusinessTextColor();
        $data['business']['color'] =  static::hex2rgb($color);
        $data['business']['x'] = $codeObj->template->configuration->getBusinessPositionX();
        $data['business']['y'] = $codeObj->template->configuration->getBusinessPositionY();

        $color = $codeObj->template->configuration->getCodeTextColor();
        $data['code']['color'] =  $this->hex2rgb($color);
        $data['code']['x'] = $codeObj->template->configuration->getCodePositionX();
        $data['code']['y'] = $codeObj->template->configuration->getCodePositionY();

        return $data;
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
