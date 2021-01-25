<?php

namespace App\Http\Requests;



class BidUpdateRequest extends BidStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('backend.bids.update');
    }
}
