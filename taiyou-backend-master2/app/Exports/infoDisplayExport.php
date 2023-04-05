<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Model\System\CheckInCheckOut;
use App\Services\System\InformationService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class infoDisplayExport implements FromCollection,WithHeadings,WithMapping, ShouldAutoSize
{

    protected $result;

    function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * @return \Illuminate\Support\Collection
     */


    public function collection()
    {
        $data = $this->result;

        $data->makeHidden(['created_at', 'updated_at', 'token']);
        $i = 1;
        foreach ($data as $datum) {

            $datum->id = $i;
            $i++;

        }
        return $data;
    }

    public function map($data): array
    {

        if($data->check_out == null){
            $checkOut = '';
        }
        else{
            $checkOut = $data->check_out == 'N/A' ? $data->check_out :japaneseDateTime(Carbon::parse($data->check_out));
        }

        return [
            $data->id,
            $data->mansion->mansion_name,
            $data->mansion->contractor->company_name,
            $data->buildingAdmin->username,
            $data->latitude,
            $data->longitude,
            japaneseDateTime(Carbon::parse($data->check_in)),
            $checkOut,

        ];
    }

    public function headings(): array
    {
        return [
            translate('S.N'),
            translate('Mansion Name'),
            translate('Contractor Name'),
            translate('Building Admin ID'),
            translate('Latitude'),
            translate('Longitude'),
            translate('Check-In'),
            translate('Check-Out'),
        ];
    }

}
