<?php

namespace App\Mail\system;

use App\Traits\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CheckinEmail extends Mailable
{
    use Queueable, SerializesModels, Mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($checkinDetail, $businessCategory)
    {
        $this->checkinDetail = $checkinDetail;
        $this->businessCategory = $businessCategory;
        $this->locale = Cookie::get('lang') ?? request()->header('locale')?? 'en' ;
    }

    public function subject($subject)
    {

        $this->subject = str_replace('%building_admin_name%', $this->checkinDetail->buildingAdmin->name, $subject);

        return $this;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        try{
            $check_in = date('Y-m-d H:i:s', strtotime($this->checkinDetail->check_in . ' +9 hour'));
           $category = $this->businessCategory;
           $contractorId = $this->checkinDetail->mansion->contractor->contractorId;
            if(preg_match('~[0-9]+~', $contractorId)){
                $contractorId = preg_replace( '/\D/', '', $contractorId);
            }
            elseif(!ctype_alnum($contractorId) && !ctype_alpha($contractorId)) {
                $contractorId = $contractorId;
            }
            elseif(ctype_alpha($contractorId)) {
                $contractorId = $contractorId;
            }
            else{
                $contractorId = preg_replace( '/\D/', '', $contractorId);
            }

            $data['content'] = $this->parseEmailTemplate([

                    '%building_admin_name%' => $this->checkinDetail->buildingAdmin->name,
                    '%building_admin_id%' => $this->checkinDetail->buildingAdmin->username,
                    '%business_category%' => $category,
                    '%mansion_id%' => $this->checkinDetail->mansion->mansion_id,
                    '%mansion_name%' => $this->checkinDetail->mansion->mansion_name,
                    '%contractor_id%' => $contractorId,
                    '%latitude%' => $this->checkinDetail->latitude,
                    '%longitude%' => $this->checkinDetail->longitude,
                    '%check_in%' => $check_in,

                ], 'Checkin', $this->locale);

            return $this->text('system.mail.plain',$data);
        }
        catch(\Exception $e){
            dd($e);
        }
    }
}
