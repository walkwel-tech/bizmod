<?php

namespace App\Http\Resources;

use App\Code;
use Illuminate\Http\Resources\Json\JsonResource;

class CodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = array();
        if (empty($this->resource)) {
            // invalid code
            $data['code'] = $request->code;
            $data['status'] = 'invalid';
            $data['message'] = Code::getMessageForStatus($data['status']);
        } else {
            $data = $this->resource->only([
                'code',
                'status',
                'message'
            ]);
            if ($this->resource->status == 'applied') {
                $name = $this->resource->client->first_name;
                if ($this->resource->client->last_name) {
                    $name .= ' ' . $this->resource->client->last_name;
                }
                $webhook_url = $request->webhook_url;
                $data['sender_id'] = $this->resource->business->sender_id;
                $data['b_id'] = $this->resource->business->b_id;
                $data['client_name'] = $name;
                $data['client_email'] = $this->resource->client->email;
                $data['client_phone'] = $this->resource->client->phone;
                $data['location'] = $this->resource->claim_details->get('location_no', '-');
                $data['country'] = $this->resource->claim_details->get('country_no', '-');
                if (!empty($webhook_url)) {
                    $data['webhook_response'] = '';

                    $curlData = array(
                        'username' => $name,
                        'claimed_on' => $this->resource->claimed_on,
                        'first_name' => $this->resource->client->first_name,
                        'last_name' => $this->resource->client->last_name,
                        'email' => $this->resource->client->email,
                        'code' => $this->resource->code,
                        'location' => $this->resource->claim_details->get('location_no', '-'),
                        'country' => $this->resource->claim_details->get('country_no', '-'),
                        'zip' => $this->resource->client->zip,
                        'phone1' => $this->resource->client->phone,
                        'phone_code' => $this->resource->client->country_code,
                    );

                    $payload = json_encode($curlData);
                    $ch = curl_init($request->webhook_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                    curl_setopt(
                        $ch,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($payload)
                        )
                    );
                    $result = curl_exec($ch);
                    if (!curl_errno($ch)) {
                        switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                            case 200:
                                $data['webhook_response'] = 'success';
                                break;
                            default:
                                $data['webhook_response'] = 'Unexpected HTTP code: ' . $http_code;
                        }
                    }
                    curl_close($ch);
                }
            }
        }
        return $data;
    }

    // /**
    //  * Get additional data that should be returned with the resource array.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return array
    //  */
    // public function with($request)
    // {
    //     return [
    //         'success' => ($this->resource) ? $this->resource->isAvailableToClaim() : false,
    //         //  [
    //         //     'key' => 'value',
    //         // ],
    //     ];
    // }
}
