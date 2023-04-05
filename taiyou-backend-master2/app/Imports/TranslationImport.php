<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Spatie\TranslationLoader\LanguageLine;

class TranslationImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function __construct($group){
        $this->group = $group;
    }
    public function collection(Collection $rows)
    {
        return $rows;
    }
}
