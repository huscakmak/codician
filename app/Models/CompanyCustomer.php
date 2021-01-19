<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyCustomer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'title',
        'email_address',
        'phone_number'
    ];

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

}
