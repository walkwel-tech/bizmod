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
