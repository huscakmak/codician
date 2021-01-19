<?php

namespace App\Services;

use App\Repositories\CompanyAddressRepository;

class CompanyAddressService extends BaseService
{
    /**
     * CompanyAddressService constructor.
     *
     * @param  CompanyAddressRepository  $repository
     */
    public function __construct(CompanyAddressRepository $repository)
    {
        $this->repository = $repository;
    }
}
