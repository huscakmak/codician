<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'internet_address',
        'website_html',
        'photo_url'
    ];

    public function address()
    {
        return $this->hasMany('App\Models\CompanyAddress', 'company_id', 'id')->orderBy('id', 'desc')->take(5);
    }

    public function customer()
    {
        return $this->hasMany('App\Models\CompanyCustomer', 'company_id', 'id')->orderBy('id', 'desc')->take(5);
    }

}
