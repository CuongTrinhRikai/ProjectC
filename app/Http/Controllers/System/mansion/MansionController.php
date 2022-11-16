<?php

namespace App\Http\Controllers\System\mansion;

use App\Model\System\BuildingAdmin;
use App\Model\System\BuildingAdminMansion;
use App\Model\System\Mansion;
use Illuminate\Http\Request;
use App\Services\System\MansionService;
use App\Http\Controllers\System\ResourceController;
use function MongoDB\BSON\toJSON;

class MansionController extends ResourceController
{
    public function __construct(MansionService $mansionService)
    {

        parent::__construct($mansionService);
    }
    public function storeValidationRequest()
    {
        return 'App\Http\Requests\system\mansionRequest';
    }

    public function updateValidationRequest()
    {
        return 'App\Http\Requests\system\mansionRequest';
    }

    public function moduleName()
    {
        return 'mansions';
    }

    public function viewFolder()
    {
        return 'system.mansion';
    }

    public function destroy(Request $request, $id)
    {
      $test = $this->service->delete($request, $id);

      if($test == true){
        $this->setModuleId($id);
      return redirect($this->getUrl())->withErrors(['success' => translate('Successfully deleted.')]);
      }
      return redirect($this->getUrl())->withErrors(['alert-danger' => translate('Cannot delete Mansion that is associated to Building Admin and Manual.')]);


    }

    public function generateQRCode($id)
    {
        $data = Mansion::findOrFail($id);

        $string = "dummy@dummy.com
Subject
Attendance,EmployeeNumber,".$data->contractor->contractorId.",".$data->mansion_id.",".$data->mansion_name.",".$data->mansion_phone;
//        $datum = array(
//            "id" => $data->id, //db
//            "mansion_id" => $data->mansion_id, //user input mansion id
//            "mansion_name" => $data->mansion_name
//        );
//        $jsonData = json_encode($datum, JSON_UNESCAPED_UNICODE);

        $data['qrcode'] = \QrCode::encoding('UTF-8')->size(300)->generate($string);
        return view('system.mansion.QR',$data);
    }

    public function show($id)
    {

        try {
            $data['title'] = translate('Mansion Management');
            $data['breadcrumbs'] = $this->breadcrumbForIndex();
            $data['items'] = Mansion::where('id', $id)->first();
            return view('system.mansion.view', $data);
        } catch (\Exception $e) {

        }
    }


    public function getMansionWhereContractorId($id){
        return Mansion::where("contractor_id",$id)->select('id','mansion_name', 'contractor_id')->get();
    }

    public function getMansionEditBuildingAdmin($id){
        return BuildingAdminMansion::where("building_admin_id",$id)->select('mansion_id')->get();
    }
}
