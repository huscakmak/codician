<?php

namespace App\Services;

use App\Repositories\CompanyCustomerRepository;

class CompanyCustomerService extends BaseService
{
    /**
     * CompanyCustomerService constructor.
     *
     * @param  CompanyCustomerRepository  $repository
     */
    public function __construct(CompanyCustomerRepository $repository)
    {
        $this->repository = $repository;
    }
}
