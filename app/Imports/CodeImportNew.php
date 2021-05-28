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
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;

class CodeImportNew implements ToCollection, WithHeadingRow, WithChunkReading
{

    use RemembersChunkOffset;

    /**
     * @param array $row
     *
     * @return User|null
     */
    private $dataArray;
    public function collection(Collection $rows)
    {
        $chunkOffset = $this->getChunkOffset();

        foreach ($rows as $row) {

            $dataArray[] = array(

                'batch_no'     => (isset($row['batch_no'])) ? $row['batch_no'] : '',
                'code'     => (isset($row['code'])) ? $row['code'] : '',
                'description'    => (isset($row['description'])) ? $row['description'] : '',
                'business_id'    => (isset($row['business_id'])) ? $row['business_id'] : 0,
                'given_on' => (isset($row['given_on'])) ? $row['given_on'] : null,
                'expire_on' => (isset($row['expire_on'])) ? $row['expire_on'] : date('Y-m-d H:i:s', strtotime("+18 month")),
                'client_id' => (isset($row['client_id'])) ? $row['client_id'] : $row['client_id'],
                'claimed_on' => (isset($row['claimed_on'])) ? date('Y-m-d H:i:s', strtotime($row['claimed_on'])) : null,
                'claim_details' =>  $this->getClaimDetails($row),
            );

        }

        Code::upsert($dataArray, 'code',['batch_no','description','business_id','given_on','client_id','claimed_on','claim_details']);
        // dump("batch------------------");
        // dump($chunkOffset);
        // dd($dataArray);
    }

    // private function getClientId($email)
    // {
    //     $client = Client::where('email', $email)->first();
    //     return ($client) ? $client->getKey() : null;
    // }

    // private function getBusinessId($code)
    // {
    //     $prefix = substr($code, 0, 3);
    //     $business = Business::where('prefix', $prefix)->first();
    //     return ($business) ? $business->getKey() : 0;
    // }

    private function getClaimDetails($row)
    {
        if (isset($row['page_id']) || isset($row['location']) || isset($row['country']) || isset($row['zip'])) {
            $claim_details =  json_encode(array(
                "page_id" => (isset($row['page_id'])) ? $row['page_id'] : '',
                "location" => (isset($row['location'])) ? $row['location'] : '',
                "country" => (isset($row['country'])) ? $row['country'] : '',
                "zip" => (isset($row['zip'])) ? $row['zip'] : '',
            ));
        } else {
            $claim_details = null;
        }

        //dd($claim_details);
        return $claim_details;
    }

    public function chunkSize(): int
    {
        return 5000;
    }

}
