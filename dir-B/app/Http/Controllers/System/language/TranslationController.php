<?php

namespace App\Http\Controllers\System\language;

use App\Exports\TranslationExport;
use App\Http\Controllers\System\ResourceController;
use App\Http\Requests\system\uploadExcel;
use App\Imports\TranslationImport;
use App\Model\Language;
use App\Services\System\TranslationService;
use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;

class TranslationController extends ResourceController
{
    public function __construct(TranslationService $translationService)
    {
        parent::__construct($translationService);
    }

    public function storeValidationRequest()
    {
        return 'App\Http\Requests\system\translationRequest';
    }

    public function moduleName()
    {
        return 'translations';
    }

    public function viewFolder()
    {
        return 'system.translation';
    }

    public function update($id)
    {
        $request = app()->make($this->storeValidationRequest());
        $this->service->update($request, $id);
        return response()->json(["status" => "OK"], 200);
    }

    public function downloadSample()
    {
        $file_path = public_path('sampleTranslation/sample.xls');
        return response()->download($file_path);
    }

    public function downloadExcel(Request $request, $group)
    {
        if ($group == "frontend") {
            $filename = "frontend.xls";
        } else {
            $filename = "backend.xls";
        }
        return \Excel::download(new TranslationExport($group), $filename);
    }

    public function uploadExcel(uploadExcel $request, $group)
    {
        $file = $request->excel_file;
        $fileExtension = $file->getClientOriginalExtension();
        if (!in_array($fileExtension, ['xlsx', 'xls'])) {
            return back()->withErrors(['alert-danger' => 'The file type must be xls or xlsx!']);
        }
        if (!in_array($group, ['frontend', 'backend'])) {
            return back()->withErrors(['alert-danger' => 'Please select the valid group.']);
        }
        try {
            $contents = \Excel::import(new TranslationImport($group), $file);
            $uploadedData = $contents->toArray($contents, $file);

            if (count($uploadedData[0]) <= 1) {
                return back()->withErrors(['alert-danger' => 'The file does not contain any translation content']);
            }
            $heading = $this->removeSpacesHeading($uploadedData[0][0]);
            $langShortCodes = Language::where('group', $group)->pluck('language_code')->toArray();
            array_push($langShortCodes, 'key');

            $checkValid = array_diff($heading, $langShortCodes);

            if (count($checkValid) > 0) {
                return back()->withErrors(['alert-danger' => 'Invalid translation content or the provided language may not be available.']);
            }

            unset($uploadedData[0][0]); // removing header content from file

            $this->parseAndUploadData($uploadedData, $heading, $group);

            return back()->withErrors(['alert-success' => 'The translations successfully uploaded.']);
        } catch (\Exception $e) {
            return back()->withErrors(['alert-danger' => 'There was some problem in uploading translations.']);
        }
    }

    public function removeSpacesHeading($heading)
    {
        $removed = array();
        foreach ($heading as $key => $value) {
            $removed[$key] = strtolower(trim($value));
        }
        return $removed;
    }

    public function parseAndUploadData($data, $heading, $group)
    {
        $arrayT = array();

        foreach ($data[0] as $key => $value) {
            $word = strtolower(trim(str_replace(".", "", $value[0])));
            $lang = LanguageLine::where('group', $group)->where('key', $word)->first();
            $updated = $this->formatText($value, $heading);
            if (isset($lang) || $lang !== null) {
                $lang->update([
                    'text' => $updated
                ]);
            } else {
                LanguageLine::create([
                    'key' => $word,
                    'group' => $group,
                    'text' => $updated
                ]);
            }
        }
        return $arrayT;
    }

    public function formatText($data, $heading)
    {
        unset($data[0]); // removing key field
        $arrayT = array();
        foreach ($data as $key => $value) {
            $arrayT[$heading[$key]] = $value;
        }
        return $arrayT;
    }
}
