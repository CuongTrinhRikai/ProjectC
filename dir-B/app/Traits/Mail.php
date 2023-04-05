<?php

namespace App\Traits;

use App\Model\EmailTemplate;
use Config;

trait Mail
{
    public function parseEmailTemplate($data, $emailCode, $locale="en", $company_id = null)
    {
        $replace = [];
        $with = [];
        if (isset($data)) {
            $emailTemplate = EmailTemplate::where('code', $emailCode)
                ->where('company_id', request()->company_id ?? $company_id)->with('emailTranslations')->first();
            $translation = $emailTemplate->getContentByLanguage($locale);
            if($translation == null) {
                $translation = $emailTemplate->getContentByLanguage('en');
              }
            foreach ($data as $key => $value) {
                array_push($replace, $key);
                array_push($with, $value);
            }
            $message_body = $translation->template;
            $this->subject($translation->subject);
//            $this->from($emailTemplate->from ?? Config::get('constants.FROM_MAIL'), Config::get('constants.FROM_NAME'));
            $content = str_replace($replace, $with, $message_body);
            return $content;
        }
    }
}
