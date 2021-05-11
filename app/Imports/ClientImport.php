<?php

namespace App\Imports;

use App\Client;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientImport implements ToModel , WithUpserts, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new Client([
            'first_name'     => $row['first_name'],
            'last_name'    => $row['last_name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'country_code' => $row['phone_code'],
        ]);
        // return new Client([
        //     'first_name'     => $row[1],
        //     'last_name'    => $row[2],
        //     'email' => $row[3],
        //     'phone' => $row[4],
        //     'country_code' => $row[7],
        // ]);
    }
    public function uniqueBy()
    {
        return 'email';
    }
}
