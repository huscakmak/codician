<?php

namespace App\Services;

use App\Jobs\CompanyJob;
use Illuminate\Support\Facades\Storage;

class BaseService
{
    /**
     * Bu sayfa tüm service'lerde ortak olan fonksiyonları içerir.
     */

    /**
     * @var
     */
    protected $repository;

    /**
     * Kayıt işlemleri servisi
     *
     * @param  array  $data
     * @return mixed
     */
    public function store(array $data)
    {
        $response = $this->repository->store($data);

        if ($data['service'] === 'company' && $response['id'] > 0) {
            $this->createCompanyJob($response['id']);
        }

        return $response;
    }

    /**
     * Şirket sitesinin html kodunun alınması için iş atanması
     *
     * @param  int  $id
     */
    public function createCompanyJob(int $id): void
    {
        CompanyJob::dispatch($id);
    }

    /**
     * Listeleme servisi
     *
     * @return mixed
     */
    public function index()
    {
        return $this->repository->index();
    }

    /**
     * Şirket numarasına göre adres ve müşteri listeleme servisi
     *
     * @param  int  $companyId
     * @return mixed
     */
    public function indexOneCompany(int $companyId)
    {
        return $this->repository->indexOneCompany($companyId);
    }

    /**
     * Güncelleme servisi
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        if ($data['service'] === 'company') {
            $data['photo_url'] = null;
        }

        $response = $this->repository->update($data, $id);

        if ($data['service'] === 'company' && $response['id'] > 0) {
            $this->createCompanyJob($response['id']);
        }

        return $response;
    }

    /**
     * Tek veri detayı servisi
     *
     * @param  int  $id
     * @return mixed
     */
    public function show(int $id)
    {
        return $this->repository->show($id);
    }

    /**
     * Şirket numarasına göre detayı çekme servisi
     *
     * @param  int  $id
     * @return mixed
     */
    public function getCompany(int $id)
    {
        return $this->repository->getCompany($id);
    }

    /**
     * Silme servisi
     *
     * @param  int  $id
     * @return mixed|string
     */
    public function delete(int $id)
    {
        $response = $this->repository->delete($id);

        if ($response && $response !== 'completed') {
            Storage::delete('public/'.$response);
        }

        return $response;
    }
}
