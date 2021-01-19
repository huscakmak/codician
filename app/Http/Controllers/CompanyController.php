<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class CompanyController extends BaseController
{
    /**
     * CompanyController constructor.
     *
     * @param  Request  $request
     * @param  CompanyService  $service
     */
    public function __construct(Request $request, CompanyService $service)
    {
        $this->service = $service;

        $this->rules = [
            'company_name' => 'required|max:255|alpha_tr',
            'internet_address' => 'required|max:255|starts_with:http://,https://|active_url|unique:companies'
        ];

        $request->merge(['service' => 'company']);
    }

    /**
     * Site html kodundan görsel eklenmesi
     *
     * @param  Request  $request
     * @return string
     */
    public function storeThumbnail(Request $request): string
    {
        $imageData = base64_decode($request->input('image'));
        $path = 'public/';
        $url = md5(uniqid(rand(), true)).'.jpg';

        $photo = Image::make($imageData)
            ->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->encode('jpg', 80);

        Storage::put($path.$url, $photo, 'public');

        $data = [
            "photo_url" => $url
        ];

        $this->service->updatePhoto($data, $request->input('id'));

        return $url;
    }

    /**
     * Görseli yüklenmemiş şirketlerin kontrol edilip, güncelleme işleminin tetiklenmesi
     *
     * @return mixed
     */
    public function checkThumbnail()
    {
        return $this->service->checkThumbnail();
    }

    /**
     * Anasayfa verileri
     *
     * @return Application|Factory|View
     */
    public function dashboard()
    {
        $dashboardCount = $this->service->dashboard();

        return view('dashboard', compact('dashboardCount'));
    }

}
