<?php

namespace App\Http\Controllers\Backend;

use App\Country;
use App\State;
use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function countries(Request $request)
    {
        $countries = Country::all();

        return response()->json($countries);
    }

    public function states(Request $request)
    {
        if ($request->has('country_id')) {
            $country = Country::with('states')->findOrFail($request->input('country_id'));
            $states  = $country->states;
        } else {
            $states = State::all();
        }

        return response()->json($states);
    }

    public function cities(Request $request)
    {
        if ($request->has('state_id')) {
            $state = State::with('cities')->findOrFail($request->input('state_id'));
            $cities = $state->cities;
        } else {
            $cities = City::all();
        }

        return response()->json($cities);
    }

    protected static function getPermissionKey() {
        return 'locations';
    }
}
