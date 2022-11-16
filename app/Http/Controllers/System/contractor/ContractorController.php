<?php

namespace App\Http\Controllers\System\contractor;

use App\Model\Company;
use App\Model\System\Contractor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\System\ContractorService;
use App\Http\Controllers\System\ResourceController;
use Illuminate\Support\Facades\Auth;
use Config;

class ContractorController extends ResourceController
{
    public function __construct(ContractorService $contractorService)
    {

        parent::__construct($contractorService);
    }
    public function storeValidationRequest()
    {
        return 'App\Http\Requests\system\contractorRequest';
    }

    public function updateValidationRequest()
    {
        return 'App\Http\Requests\system\contractorRequest';
    }

    public function moduleName()
    {
        return 'contractors';
    }

    public function viewFolder()
    {
        return 'system.contractor';
    }
    public function destroy(Request $request, $id)
    {

      $test = $this->service->delete($request, $id);

      if($test == true){
        $this->setModuleId($id);
      return redirect($this->getUrl())->withErrors(['success' => translate('Successfully deleted.')]);
      }
      return redirect($this->getUrl())->withErrors(['alert-danger' => translate('Cannot delete Contractor that is associated to Building Admin and Mansion')]);


    }

    public function show($id)
    {

        try {
            $contractor = Contractor::where('id', $id)->first();
            $data['title'] = translate('Contractor Management');
            $data['breadcrumbs'] = $this->breadcrumbForIndex();
            $data['items'] = $contractor;
            $data['name_company'] = Company::where('id', $contractor->company_id)->first()->name;
            return view('system.contractor.view', $data);
        } catch (\Exception $e) {

        }
    }
}
