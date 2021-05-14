<?php

namespace App\Exports;

use App\Business;
use Maatwebsite\Excel\Concerns\FromCollection;

class BusinessExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Business::all();
    }
}
