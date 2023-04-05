<?php
namespace App\Transformers;

use Carbon\Carbon;

use App\Model\System\Manual;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

class ManualTransformer extends TransformerAbstract
{
  public function transform(Manual $manual)
  {
    $url = Storage::disk('s3')->temporaryUrl($manual->url, now()->addMinutes(5));
    if($manual->manual_type==1){
        $manual->manual_type ='pdf';
    }else{
        $manual->manual_type ='video';
    }
    if($manual->flag==1){
        $manual->flag ='active';
    }else{
        $manual->flag ='inActive';
    }

    return [
        'ID'=>$manual->id,
        'manualID'=>$manual->manual_id,
        'manualName'=>$manual->name,
        'mansionName'=>$manual->mansions->mansion_name ?? null,
        'mansionID'=>$manual->mansions->mansion_id ?? null,
        'url'=>$url ?? null,
        'manualType'=>$manual->manual_type,
        'flag'=>$manual->flag,
        'createdAt' => japaneseDateTime(Carbon::parse($manual->created_at)->format('Y-m-d')),
        'updatedAt' => japaneseDateTime(Carbon::parse($manual->updated_at)->format('Y-m-d'))
    ];
  }
}
