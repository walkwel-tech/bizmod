<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel , WithUpserts, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        //dd($row);
        return new User([
            'first_name'     => (isset($row['first'])) ? $row['first'] : '',
            'middel_name'    => (isset($row['middel'])) ? $row['middel'] : '',
            'last_name'    => (isset($row['last'])) ? $row['last'] : '',
            'email' => (isset($row['email'])) ? $row['email'] : '',
            'username' => $this->computeUserNameForRow($row),
            'password' => (isset($row['password'])) ? $row['password'] : Hash::make($row['first'].'@123!'),
        ]);
    }

    private function computeUserNameForRow(array $row) {
        $username = str_replace(['@', ',', '\'', '~'],'',$row['email']);

        return $username;
    }

    public function uniqueBy()
    {
        return 'email';
    }
}
