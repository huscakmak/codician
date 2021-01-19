<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\CompanyCustomer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CompanyCustomerRepository extends BaseRepository
{

    /**
     * CompanyCustomerRepository constructor.
     *
     * @param  CompanyCustomer  $model
     */
    public function __construct(CompanyCustomer $model)
    {
        $this->model = $model;
    }

    /**
     * Listeleme database işlemleri
     *
     * @return mixed
     */
    public function index()
    {
        return $this->model->orderBy('id', 'desc')->with('company')->paginate(25);
    }

    /**
     * Tek veri bilgileri database işlemleri
     *
     * @param  int  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function show(int $id)
    {
        return $this->model->with('company')->findOrFail($id);
    }

    /**
     * Silme database işlemleri
     *
     * @param  int  $id
     * @return string
     */
    public function delete(int $id)
    {
        $this->model->where('id', $id)->delete();

        return 'completed';
    }

    /**
     * Şirket numarasına göre şirket bilgisi alma database işlemleri
     *
     * @param  int  $id
     * @return mixed
     */
    public function getCompany(int $id)
    {
        return Company::findOrFail($id);
    }
}
