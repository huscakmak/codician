<?php

namespace App\Http\Controllers;

use App\Services\CompanyAddressService;
use Illuminate\Http\Request;

class CompanyAddressController extends BaseController
{
    /**
     * CompanyAddressController constructor.
     *
     * @param  Request  $request
     * @param  CompanyAddressService  $service
     */
    public function __construct(Request $request, CompanyAddressService $service)
    {
        $this->service = $service;

        $this->rules = [
            'company_id' => 'required|numeric|min:1',
            'province' => 'required|alpha_tr|max:255',
            'district' => 'required|alpha_tr|max:255',
            'neighborhood' => 'required|alpha_num_tr|max:255',
            'street' => 'required|alpha_num_tr|max:255',
            'building_number' => 'required|alpha_num_tr|max:255',
            'door_number' => 'required|alpha_num_tr|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ];

        $request->merge(['service' => 'companyAddress']);
    }

}
