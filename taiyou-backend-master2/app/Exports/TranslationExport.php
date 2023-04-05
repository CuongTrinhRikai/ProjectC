<?php

namespace App\Exports;

use App\Model\Language;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Spatie\TranslationLoader\LanguageLine;

class TranslationExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($group){
        $this->group = $group;
    }
    public function view(): View
    {
        return view('system.exports.translations', [
            'translations' => LanguageLine::where('group', $this->group)->get(),
            'languages' => Language::where('group', $this->group)->get()
        ]);
    }
}
