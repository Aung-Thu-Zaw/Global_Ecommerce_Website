<?php

namespace App\Actions\Ecommerce;

use App\Models\DeliveryInformation;

class CreateDeliveryInformationAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): void
    {
        DeliveryInformation::create([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'country' => $data['country'],
            'region' => $data['region'],
            'city' => $data['city'],
            'township' => $data['township'],
            'postal_code' => $data['postal_code'],
            'additional_information' => $data['additional_information'],
        ]);
    }
}
