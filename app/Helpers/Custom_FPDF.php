<?php

namespace App\Helpers;

use setasign\Fpdi\Fpdi;

class Custom_FPDF extends Fpdi
{

    protected $FontSpacingPt;      // current font spacing in points
    protected $FontSpacing;        // current font spacing in user units

    function SetFontSpacing($size)
    {
        if ($this->FontSpacingPt == $size)
            return;
        $this->FontSpacingPt = $size;
        $this->FontSpacing = $size / $this->k;
        if ($this->page > 0)
        //dd(sprintf('BT %.3f Tc ET', $size));
            $this->_out(sprintf('BT %.3f Tc ET', $size));
    }

    protected function _dounderline($x, $y, $txt)
    {
        // Underline text
        $up = $this->CurrentFont['up'];
        $ut = $this->CurrentFont['ut'];
        $w = $this->GetStringWidth($txt) + $this->ws * substr_count($txt, ' ') + (strlen($txt) - 1) * $this->FontSpacing;
        return sprintf('%.2F %.2F %.2F %.2F re f', $x * $this->k, ($this->h - ($y - $up / 1000 * $this->FontSize)) * $this->k, $w * $this->k, -$ut / 1000 * $this->FontSizePt);
    }

    function GetStringWidth($s)
{
    // Get width of a string in the current font
    $s = (string)$s;
    $cw = &$this->CurrentFont['cw'];
    $w = 0;
    $l = strlen($s);
    for($i=0;$i<$l;$i++) {
        $charw = $cw[$s[$i]];
        $wtf = $this->FontSpacing/1.7+1;
        $w += $charw*$wtf;
    }
    return $w*$this->FontSize/1000;
}


}
