<?php

namespace App\Http\Controllers\System\infoDisplay;

use App\Exports\infoDisplayExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\System\ResourceController;
use App\Model\System\CheckInCheckOut;
use App\Services\System\InformationService;
use Illuminate\Http\Request;

class InformationController extends ResourceController
{
    public function __construct(InformationService $informationService)
    {
        parent::__construct($informationService);
        $this->model = $informationService;

    }

    public function storeValidationRequest()
    {
        return 'App\Http\Requests\system\InfoDisplayRequest';
    }

    public function moduleName()
    {

        return 'info-display';
    }

    public function moduleToTitle()
    {

        $title = "";
        $data = explode('-', $this->moduleName());
        foreach ($data as $d) {
            $title .= $d . ' ';
        }
        return ucwords("Information Display Management");
    }

    public function viewFolder()
    {
        return 'system.infoDisplay';
    }



    public function downloadExcel(Request $request)
    {

       $result = $this->service->allInfo($request);
        return \Excel::download(new infoDisplayExport($result),  'check-in-check-out.xlsx');
    }

    public function show($id)
    {
        try {
            $data['title'] = translate('Information Display Management');
            $data['breadcrumbs'] = $this->breadcrumbForIndex();
            $data['items'] = CheckInCheckOut::where('id', $id)->first();
            return view('system.infoDisplay.view', $data);
        } catch (\Exception $e) {

        }
    }

    public function destroy(Request $request, $id)
    {
        $test = $this->service->delete($request, $id);
        if ($test == true) {
            $this->setModuleId($id);

            return redirect($this->getUrl())->withErrors(['success' => translate('Successfully deleted.')]);
        }
        return redirect($this->getUrl())->withErrors(['alert-danger' => translate('Cannot delete.')]);


    }
}
