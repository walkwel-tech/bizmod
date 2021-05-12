<?php

namespace App\Imports;

use App\Client;
use App\Business;
use App\Code;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CodeImport implements ToModel, WithHeadingRow, WithBatchInserts, WithUpserts, WithChunkReading
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        //dd($row);
        $code = new Code([
            'batch_no'     => (isset($row['batch_no'])) ? $row['batch_no'] : '',
            'code'     => (isset($row['code'])) ? $row['code'] : '',
            'description'    => (isset($row['description'])) ? $row['description'] : '',
            'business_id'    => $this->getBusinessId($row['code']),
            'given_on' => (isset($row['given_on'])) ? $row['given_on'] : null,
            'expire_on' => (isset($row['expire_on'])) ? $row['expire_on'] : date('Y-m-d H:i:s', strtotime("+18 month")),
        ]);
        $code->client_id = $this->getClientId($row['user_email']);
        $code->claimed_on = (isset($row['claimed_on'])) ? date('Y-m-d H:i:s', strtotime($row['claimed_on'])) : null;
        $code->claim_details = $this->getClaimDetails($row);
        return $code;
    }

    private function getClientId($email) {
        $client = Client::where('email',$email)->first();
        return ($client) ? $client->getKey() : null;

    }

    private function getBusinessId($code)
    {
        $prefix = substr($code, 0, 3);
        $business = Business::where('prefix', $prefix)->first();
        return ($business) ? $business->getKey() : 0;
    }

    private function getClaimDetails(array $row)
    {
            $claim_details =  json_encode([
            "page_id" => (isset($row['page_id'])) ? $row['page_id'] : '',
            "location" => (isset($row['location'])) ? $row['location'] : '',
            "country" => (isset($row['country'])) ? $row['country'] : '',
            "zip" => (isset($row['zip'])) ? $row['zip'] : '',
        ]);
        //dd($claim_details);
        return $claim_details;
    }

    public function uniqueBy()
    {
        return 'code';
    }
    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
