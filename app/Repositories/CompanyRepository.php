<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\CompanyCustomer;

class CompanyRepository extends BaseRepository
{

    /**
     * CompanyRepository constructor.
     *
     * @param  Company  $model
     */
    public function __construct(Company $model)
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
        return $this->model->orderBy('id', 'desc')->paginate(25);
    }

    /**
     * Tek veri bilgileri database işlemleri
     *
     * @param  int  $id
     * @return mixed
     */
    public function show(int $id)
    {
        return $this->model->where('id', $id)->with('address')->with('customer')->first();
    }

    /**
     * Silme database işlemleri
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $company = $this->model->findOrFail($id);
        $image = $company->photo_url;

        CompanyAddress::where('company_id', $id)->delete();
        CompanyCustomer::where('company_id', $id)->delete();
        $company->delete();

        return $image;
    }

    /**
     * Görseli olmayan şirketleri kontrol database işlemleri
     *
     * @return mixed
     */
    public function checkThumbnail()
    {
        return $this->model->whereNull('photo_url')->whereNotNull('website_html')->first();
    }

    /**
     * Ana sayfadaki verilerin alınma database işlemleri
     *
     * @return array
     */
    public function dashboard()
    {
        $data['company'] = Company::count();
        $data['company_address'] = CompanyAddress::count();
        $data['company_customer'] = CompanyCustomer::count();

        return $data;
    }
}
