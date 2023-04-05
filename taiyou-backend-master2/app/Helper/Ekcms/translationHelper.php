<?php

use App\Model\Language;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Spatie\TranslationLoader\LanguageLine;

function translate($content, $data = [], $group = "backend")
{
    $key = strtolower(trim(str_replace(".", "", $content)));

    $translations = array_keys(LanguageLine::getTranslationsForGroup(Cookie::get('lang') ?? 'en', $group));

    if ($key !== "") {
        if (!in_array($key, $translations)) {
            $check = LanguageLine::where('key', $key)->where('group', $group)->exists();
            if ($check) {
                return trans($group . '.' . $key, $data);
            } else {
                if ($key !== "") {
                    LanguageLine::create([
                        'group' => $group,
                        'key' => $key,
                        'text' => insertText($content, $group),
                    ]);
                    return $content;
                }
            }
        } else {
            $trans = trans($group . '.' . $key, $data);
            if ($trans == $group . "." . $key) {return $content;}
            else {return $trans;}
        }
    } else {return $key;}
}

function insertText($content, $group)
{
    $languages = Language::where('group', $group)->orderBy('group', 'ASC')->pluck('language_code');
    $text = array();
    foreach ($languages as $language) {
        $text[$language] = $content;
    }
    return $text;
}

function translateValidationErrorsOfApi($content, $data = [], $group = 'frontend')
{
    return translate($content, $data, $group);
}

//frontend tranalation function 

function frontTrans($content, $data = [], $group = 'frontend'){
    return translate($content, $data, $group);
}
