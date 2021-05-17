<?php

namespace App\Imports;

use App\Client;
use App\Business;
use App\Code;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;

class CodeImportNew implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    private $datArray;
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            $datArray[] = array(

                'batch_no'     => (isset($row['batch_no'])) ? $row['batch_no'] : '',
                'code'     => (isset($row['code'])) ? $row['code'] : '',
                'description'    => (isset($row['description'])) ? $row['description'] : '',
                'business_id'    => (isset($row['business_id'])) ? $row['business_id'] : '',
                'given_on' => (isset($row['given_on'])) ? $row['given_on'] : null,
                'expire_on' => (isset($row['expire_on'])) ? $row['expire_on'] : date('Y-m-d H:i:s', strtotime("+18 month")),
                'client_id' => (isset($row['client_id'])) ? $row['client_id'] : null,
                'claimed_on' => (isset($row['claimed_on'])) ? date('Y-m-d H:i:s', strtotime($row['claimed_on'])) : null,
                'claim_details' =>  $this->getClaimDetails($row),
            );

        }
        dump("batch------------------");
        dump($datArray);
    }

    private function getClientId($email)
    {
        $client = Client::where('email', $email)->first();
        return ($client) ? $client->getKey() : null;
    }

    private function getBusinessId($code)
    {
        $prefix = substr($code, 0, 3);
        $business = Business::where('prefix', $prefix)->first();
        return ($business) ? $business->getKey() : 0;
    }

    private function getClaimDetails($row)
    {
        if (isset($row['page_id']) || isset($row['location']) || isset($row['country']) || isset($row['zip'])) {
            $claim_details =  array(
                "page_id" => (isset($row['page_id'])) ? $row['page_id'] : '',
                "location" => (isset($row['location'])) ? $row['location'] : '',
                "country" => (isset($row['country'])) ? $row['country'] : '',
                "zip" => (isset($row['zip'])) ? $row['zip'] : '',
            );
        } else {
            $claim_details = '';
        }

        //dd($claim_details);
        return $claim_details;
    }

    public function chunkSize(): int
    {
        return 10000;
    }

}
