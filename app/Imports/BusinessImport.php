<?php

namespace App\Imports;

use App\User;
use App\Business;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BusinessImport implements ToModel , WithUpserts, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        //dd($row);
        return new Business([
            'title'     => (isset($row['business'])) ? $row['business'] : '',
            'slug'     => $this->slugify($row['business']),
            'description'    => (isset($row['description'])) ? $row['description'] : '',
            'prefix'    => (isset($row['prefix'])) ? $row['prefix'] : '',
            'owner_id' => $this->getOwnerId($row),
            'threshold' => (isset($row['threshold'])) ? $row['threshold'] : '',
            'webhook_url' => (isset($row['webhook_url'])) ? $row['webhook_url'] : '',
            'b_id' => (isset($row['fbde_business'])) ? $row['fbde_business'] : '',
            'sender_id' => (isset($row['fbde_sender'])) ? $row['fbde_sender'] : '',
        ]);
    }

    private function getOwnerId(array $row) {
        $user = User::where('email',$row['email'])->first();
        return ($user) ? $user->getKey() : 0;

    }

    public function slugify($title)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
    }

    public function uniqueBy()
    {
        return 'prefix';
    }
}
