<?php

namespace App\Http\Controllers\System\manual;

use App\Model\System\Manual;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\System\ManualService;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\System\ResourceController;

class ManualController extends ResourceController
{
    public function __construct(ManualService $manualService)
    {

        parent::__construct($manualService);
    }

    public function storeValidationRequest()
    {
        return 'App\Http\Requests\system\manualRequest';
    }

    public function updateValidationRequest()
    {
        return 'App\Http\Requests\system\manualRequest';
    }

    public function moduleName()
    {
        return 'manuals';
    }

    public function viewFolder()
    {
        return 'system.manual';
    }



    public function destroy(Request $request, $id)
    {
        $test = $this->service->delete($request, $id);
        if ($test == true) {
            $this->setModuleId($id);

            return redirect($this->getUrl())->withErrors(['success' => translate('Successfully deleted.')]);
        }
        return redirect($this->getUrl())->withErrors(['alert-danger' => translate('Cannot  delete Mnaual.')]);


    }

    //Signed Url for upload
    public function getUploadSignedUrl(Request $request)
    {
        $signedData = preSignedUrl($request->fileName, $request->type);

        return response()->json(['url' => $signedData['url'], 'status' => 'success', 'fileName' => $signedData['filename']]);
    }

    public function removeS3File(Request $request)
    {
        Storage::disk('s3')->delete($request->fileName);

        return response()->json(['data' => true]);
    }

    public function getUploadSignedUrlupdate(Request $request)
    {
        $signedData = preSignedUrl($request->fileName, $request->type);

        return response()->json(['url' => $signedData['url'], 'status' => 'success', 'fileName' => $signedData['filename']]);
    }

    public function checkUnique(Request $request)
    {
        return response()->json($this->service->validateUnique($request->col,$request->value,$request->id));
    }

    public function testing()
    {
        $test = Storage::disk('s3')->allFiles('');
    }

    public function show($id)
    {

        try {
            $data['title'] = translate('Manual Management');
            $data['breadcrumbs'] = $this->breadcrumbForIndex();
            $data['items'] = Manual::where('id', $id)->first();
            $data['url'] = Storage::disk('s3')->temporaryUrl( $data['items']->url, now()->addDays(5));
            return view('system.manual.view', $data);
        } catch (\Exception $e) {

        }
    }
}
