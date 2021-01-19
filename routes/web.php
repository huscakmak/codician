<?php

use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'CompanyController@dashboard');

/**
 * Şirket adresleriyle ilgili işlemlerin Route'ları
 */
Route::group(['prefix' => 'company-address'], function () {
    Route::get('list', 'CompanyAddressController@index');
    Route::get('list/{companyId}', 'CompanyAddressController@indexOneCompany')->where('companyId', '[0-9]+');
    Route::get('add/{companyId}', 'CompanyAddressController@storeView')->where('companyId', '[0-9]+');
    Route::post('add', 'CompanyAddressController@store');
    Route::get('view/{id}', 'CompanyAddressController@showView')->where('id', '[0-9]+');
    Route::get('delete/{id}', 'CompanyAddressController@deleteView')->where('id', '[0-9]+');
    Route::delete('delete/{id}', 'CompanyAddressController@delete')->where('id', '[0-9]+');
    Route::get('edit/{id}', 'CompanyAddressController@updateView')->where('id', '[0-9]+');
    Route::put('edit/{id}', 'CompanyAddressController@update')->where('id', '[0-9]+');

});

/**
 * Şirket müşterileriyle ilgili işlemlerin Route'ları
 */
Route::group(['prefix' => 'company-customer'], function () {
    Route::get('list', 'CompanyCustomerController@index');
    Route::get('list/{companyId}', 'CompanyCustomerController@indexOneCompany')->where('companyId', '[0-9]+');
    Route::get('add/{companyId}', 'CompanyCustomerController@storeView')->where('companyId', '[0-9]+');
    Route::post('add', 'CompanyCustomerController@store');
    Route::get('view/{id}', 'CompanyCustomerController@showView')->where('id', '[0-9]+');
    Route::get('delete/{id}', 'CompanyCustomerController@deleteView')->where('id', '[0-9]+');
    Route::delete('delete/{id}', 'CompanyCustomerController@delete')->where('id', '[0-9]+');
    Route::get('edit/{id}', 'CompanyCustomerController@updateView')->where('id', '[0-9]+');
    Route::put('edit/{id}', 'CompanyCustomerController@update')->where('id', '[0-9]+');

});

/**
 * Şirketlerle ilgili işlemlerin Route'ları
 */
Route::group(['prefix' => 'company'], function () {
    Route::get('list', 'CompanyController@index');
    Route::get('add', function () {
        return view('company.add');
    });
    Route::post('add', 'CompanyController@store');
    Route::get('view/{id}', 'CompanyController@showView')->where('id', '[0-9]+');
    Route::get('delete/{id}', 'CompanyController@deleteView')->where('id', '[0-9]+');
    Route::delete('delete/{id}', 'CompanyController@delete')->where('id', '[0-9]+');
    Route::get('edit/{id}', 'CompanyController@updateView')->where('id', '[0-9]+');
    Route::put('edit/{id}', 'CompanyController@update')->where('id', '[0-9]+');
    Route::post('save-thumbnail', 'CompanyController@storeThumbnail');
    Route::get('check-thumbnail', 'CompanyController@checkThumbnail');

});

/**
 * Yüklenen görsellerin public dizininde gösterilmesi
 */
Route::get('storage/{filename}', function ($filename)
{
    return Image::make(storage_path('app/public/' . $filename))->response();
});
