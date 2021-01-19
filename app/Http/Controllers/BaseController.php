<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Throwable;

class BaseController extends Controller
{
    /**
     * Bu sayfa tüm controller'da ortak olan fonksiyonları içerir.
     */

    /**
     * @var
     */
    protected $service;

    /**
     * Validasyon kurallarını tanımlar
     *
     * @var array
     */
    public $rules = [];

    /**
     * Hangi serviste olduğunun tanımlar
     *
     * @var string
     */
    public $serviceArea = '';

    /**
     * Veri kaydetme
     *
     * @param  Request  $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $detail = $this->service->store($request->all());

            $success = 'Data has been saved successfully.';
        } catch (Throwable $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        $viewPath = $request->path();

        if ($request->input('service') === 'companyAddress' || $request->input('service') === 'companyCustomer') {
            $viewPath = $viewPath.'/'.$request->input('company_id');
        }

        return redirect($viewPath)->with(['detail' => $detail, 'success' => $success]);
    }

    /**
     * Tüm verilerin listelenmesi
     *
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $viewPath = $request->path();

        $list = $this->service->index();

        return view($viewPath, compact('list'));
    }

    /**
     * Şirket numarasına göre adres ve müteri listeleme
     *
     * @param  Request  $request
     * @param  int  $companyId
     * @return Application|Factory|View
     */
    public function indexOneCompany(Request $request, int $companyId)
    {
        $list = $this->service->indexOneCompany($companyId);

        return view($request->segment(1).'.list', compact('list'));
    }

    /**
     * Kayıt sayfasının gösterimi
     *
     * @param  Request  $request
     * @param  int  $companyId
     * @return Application|Factory|View
     */
    public function storeView(Request $request, int $companyId)
    {
        $company = $this->service->getCompany($companyId);

        return view($request->segment(1).'.add', compact('company'));
    }

    /**
     * Güncelleme sayfasının gösterimi
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function updateView(Request $request, int $id)
    {
        $detail = $this->service->show($id);

        return view($request->segment(1).'.edit', compact('detail'));
    }

    /**
     * Silme sayfasının gösterimi
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function deleteView(Request $request, int $id)
    {
        $detail = $this->service->show($id);

        return view($request->segment(1).'.delete', compact('detail'));
    }

    /**
     * Silme işlemleri
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function delete(Request $request, int $id)
    {
        try {
            $this->service->delete($id);

            $success = 'Data has been deleted successfully.';
        } catch (Throwable $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect($request->segment(1).'/list')->with(['success' => $success]);
    }

    /**
     * Güncelleme işlemleri
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, int $id)
    {
        $this->ruleUpdateEdit($id);

        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $detail = $this->service->update($request->all(), $id);

            $success = 'Data has been updated successfully.';
        } catch (Throwable $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        $viewPath = $request->path();

        return redirect($viewPath)->with(['detail' => $detail, 'success' => $success]);
    }

    /**
     * Detay sayfasının gösterimi
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function showView(Request $request, int $id)
    {
        $detail = $this->service->show($id);

        return view($request->segment(1).'.view', compact('detail'));
    }

    /**
     * Güncelleme işlemleri için validasyon kurallarının güncellenmesi
     *
     * @param  int  $id
     */
    public function ruleUpdateEdit(int $id)
    {
        if (isset($this->rules['email_address'])) {
            $emailArray = [
                'email_address' => $this->rules['email_address'].',id,'.$id
            ];
            $this->rules = array_merge($this->rules, $emailArray);
        }

        if (isset($this->rules['phone_number'])) {
            $phoneArray = [
                'phone_number' => $this->rules['phone_number'].',id,'.$id
            ];
            $this->rules = array_merge($this->rules, $phoneArray);
        }

        if (isset($this->rules['internet_address'])) {
            $internetArray = [
                'internet_address' => $this->rules['internet_address'].',id,'.$id
            ];
            $this->rules = array_merge($this->rules, $internetArray);
        }

        $this->rules = array_unique($this->rules);
    }
}
