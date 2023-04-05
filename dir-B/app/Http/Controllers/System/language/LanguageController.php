<?php

namespace App\Http\Controllers\System\language;

use App\Http\Controllers\System\ResourceController;
use App\Services\System\LanguageService;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends ResourceController
{
    public function __construct(LanguageService $languageService)
    {
        parent::__construct($languageService);
    }

    public function storeValidationRequest()
    {
        return 'App\Http\Requests\system\languageRequest';
    }

    public function moduleName()
    {
        return 'languages';
    }

    public function viewFolder()
    {
        return 'system.language';
    }

    public function setLanguage($lang)
    {

        Cookie::queue('lang', $lang, 20000);
        session()->put('lang', $lang);
        return back();
    }
}
