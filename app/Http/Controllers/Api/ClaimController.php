<?php

namespace App\Http\Controllers\Api;

use App\Code;
use App\Business;
use App\Client;
use App\Http\Resources\CodeResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\ClaimValidateRequest;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

class ClaimController extends Controller
{
    public function show(Request $request, $code)
    {
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
            'country_name',
            'zip',
        ]));


        return (new CodeResource($code))
            ->additional([
                'success' => true
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
