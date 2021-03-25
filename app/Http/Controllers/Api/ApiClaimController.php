<?php

namespace App\Http\Controllers\Api;

use App\Code;
use App\User;
use App\Client;
use App\Http\Resources\CodeResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\ClaimValidateRequest;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class ApiClaimController extends Controller
{
    public function show(Request $request, $code)
    {
        // $business = $request->user();
        // $codeObject = $business->codes()->code($code)->first();

        $codeObject = Code::code($code)->first();

        return (new CodeResource($codeObject))
            ->additional([
                'success' => ($codeObject) ? $codeObject->isAvailableToClaim() : false,
            ]);
    }

    /**
     * @param \App\Http\Requests\ClaimValidateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClaimValidateRequest $request, Code $code)
    {

        $client = Client::firstOrCreate(
                $request->only([
                    'email'
                ]),
                $request->only([
                'first_name',
                'last_name',
                'phone',
                'country_name',
                'country_code',
                'zip',
            ])
        );

        $status = $code->applyCodeForClient($client, $request->only([
            'page_id',
            'location',
            'location_no',
            'country_name',
            'country_no',
            'zip',
        ]));

        $name = $code->client->first_name;
        if ($code->client->last_name) {
            $name .= ' ' . $code->client->last_name;
        }

        return (new CodeResource($code))
            ->additional([
                'success' => true,
                'sender_id' => $code->business->sender_id,
                'b_id' => $code->business->b_id,
                'client_name' => $name,
                'client_email' => $code->client->email,
                'client_phone' => $code->client->phone,
                'location' => $code->claim_details->get('location_no', '-'),
                'country' => $code->claim_details->get('country_no', '-')
            ]);
    }


    protected static function requiresPermission()
    {
        return false;
    }

    protected static function getPermissionKey()
    {
        return 'codes';
    }

    public static function getModelName()
    {
        return 'Code';
    }

    public static function getAllowedFilters()
    {
        return [
            'code' => [
                'type' => 'input',
                'title' => 'Code'
            ],
            'business.title' => [
                'type' => 'input',
                'title' => 'Business Title'
            ],
            'client.email' => [
                'type' => 'input',
                'title' => 'Customer Email'
            ]
        ];
    }
}
