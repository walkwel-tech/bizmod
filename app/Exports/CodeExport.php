<?php

namespace App\Exports;

use App\Code;
use Maatwebsite\Excel\Concerns\FromCollection;

class CodeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Code::all();
    }
}
