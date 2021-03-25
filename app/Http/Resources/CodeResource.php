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
            if($this->resource->status=='applied')
            {
                $name = $this->resource->client->first_name;
                if ($this->resource->client->last_name) {
                    $name .= ' ' . $this->resource->client->last_name;
                }
                    $data['sender_id'] = $this->resource->business->sender_id;
                    $data['b_id'] = $this->resource->business->b_id;
                    $data['client_name'] = $name;
                    $data['client_email'] = $this->resource->client->email;
                    $data['client_phone'] = $this->resource->client->phone;
                    $data['location'] = $this->resource->claim_details->get('location_no', '-');
                    $data['country'] = $this->resource->claim_details->get('country_no', '-');
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
