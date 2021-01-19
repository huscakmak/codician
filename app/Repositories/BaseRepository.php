<?php

namespace App\Repositories;

class BaseRepository
{
    /**
     * Bu sayfa tüm repository'lerde ortak olan fonksiyonları içerir.
     */

    /**
     * @var
     */
    protected $model;

    /**
     * Kayıt işlemleri
     *
     * @param  array  $data
     * @return mixed
     */
    public function store(array $data)
    {
        $createData = $this->model->create($data);

        return $createData->fresh();
    }

    /**
     * Şirket numarasına göre adres ve müşteri seçimi
     *
     * @param  int  $companyId
     * @return mixed
     */
    public function indexOneCompany(int $companyId)
    {
        return $this->model->where('company_id', $companyId)->orderBy('id', 'desc')->with('company')->paginate(25);
    }

    /**
     * Güncelleme işlemleri
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $updateData = $this->model->findOrFail($id);

        $updateData->fill($data);

        $updateData->save();

        return $updateData->fresh();
    }
}
