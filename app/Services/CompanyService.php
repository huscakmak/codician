<?php

namespace App\Services;

use App\Repositories\CompanyRepository;

class CompanyService extends BaseService
{
    /**
     * CompanyService constructor.
     *
     * @param  CompanyRepository  $repository
     */
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Şirket görseli güncelleme servisi
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    public function updatePhoto(array $data, int $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * Görseli olmayan sitelerin kontrol servisi
     *
     * @return mixed
     */
    public function checkThumbnail()
    {
        return $this->repository->checkThumbnail();
    }

    /**
     * Anasayfadaki verilerin servisi
     * @return array
     */
    public function dashboard()
    {
        return $this->repository->dashboard();
    }
}
