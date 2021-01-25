<?php

namespace App\Traits;

use App\Country;
use App\City;
use App\State;
use App\Address;
use Illuminate\Support\Arr;

trait HasAddresses
{
    public function getFirstAddress()
    {
        $address = $this->addresses()->first() ?? new Address([
            'title' => $this->getSEOTitle(),
            'line_1' => 'Address for ' . $this->getSEOTitle(),
            'locatable_type' => self::class,
            'locatable_id' => $this->id,
        ]);

        return $address;
    }

    public function getAddressAttribute()
    {
        return $this->getFirstAddress();
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'locatable');
    }

    public function syncAddresses($addresses, $countries, $states, $cities)
    {
        $currentAddresses = $this->addresses;

        if ($currentAddresses->isNotEmpty()) {
            $currentAddresses->each(function ($address) use ($addresses, $countries, $states, $cities) {
                $dataToUpdate = collect($addresses[$address->slug]);
                $dataToUpdate->put('country_id', Arr::get($countries, $address->slug));
                $dataToUpdate->put('state_id', Arr::get($states, $address->slug));
                $dataToUpdate->put('city_id', Arr::get($cities, $address->slug));
                $address->fill($dataToUpdate->filter()->toArray());
                $address->save();
            });
        } else {
            $addressObjects = collect($addresses)->map(function ($address, $slug) use ($countries, $states, $cities) {
                $addressObject = new Address($address);
                $addressObject['country_id'] = Arr::get($countries, $slug);
                $addressObject['state_id'] = Arr::get($states, $slug);
                $addressObject['city_id'] = Arr::get($cities, $slug);

                return $addressObject;
            });

            $this->addresses()->saveMany($addressObjects);
        }


        $newAddressslug = 'new_address';
        if (isset($addresses[$newAddressslug])) {
            $dataToInsert = collect($addresses[$newAddressslug]);
            $dataToInsert->put('country_id', Arr::get($countries, $newAddressslug));
            $dataToInsert->put('state_id', Arr::get($states, $newAddressslug));
            $dataToInsert->put('city_id', Arr::get($cities, $newAddressslug));

            if ($dataToInsert->get('title') && $dataToInsert->get('line_1')) {
                $this->addresses()->create($dataToInsert->filter()->toArray());
            }
        }

        return $this->addresses()->get();
    }

    public function relatesToCountry(Country $country)
    {
        return $this->addresses()->pluck('country_id')->contains($country->id);
    }

    public function relatesToState(State $state)
    {
        return $this->addresses()->pluck('state_id')->contains($state->id);
    }
    public function relatesToCity(City $city)
    {
        return $this->addresses()->pluck('city_id')->contains($city->id);
    }
}
