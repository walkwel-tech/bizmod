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
            'first_name'     => (isset($row['first_name'])) ? $row['first_name'] : '',
            'last_name'    => (isset($row['last_name'])) ? $row['last_name'] : '',
            'email' => (isset($row['email'])) ? $row['email'] : '',
            'phone' => (isset($row['phone'])) ? $row['phone'] : '',
            'country_name' => (isset($row['country_name'])) ? $row['country_name'] : '',
            'country_code' => (isset($row['phone_code'])) ? substr($row['phone_code'],0,4) : '',
            'zip' => (isset($row['zip'])) ? $row['zip'] : '',
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
