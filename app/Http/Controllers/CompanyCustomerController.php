<?php

namespace App\Http\Controllers;

use App\Services\CompanyCustomerService;
use Illuminate\Http\Request;

class CompanyCustomerController extends BaseController
{
    /**
     * CompanyCustomerController constructor.
     *
     * @param  Request  $request
     * @param  CompanyCustomerService  $service
     */
    public function __construct(Request $request, CompanyCustomerService $service)
    {
        $this->service = $service;

        $this->rules = [
            'company_id' => 'required|numeric|min:1',
            'first_name' => 'required|alpha_tr|max:255',
            'last_name' => 'required|alpha_tr|max:255',
            'title' => 'required|in:Mr.,Mrs.,Miss,Dr,Ms.,Mx.',
            'email_address' => 'required|email:rfc|unique:company_customers',
            'phone_number' => 'required|max:10|min:10|starts_with:5|unique:company_customers'
        ];

        $request->merge(['service' => 'companyCustomer']);
    }

}
