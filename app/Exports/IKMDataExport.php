<?php

namespace App\Exports;

use App\Models\IKMData;
use Maatwebsite\Excel\Concerns\FromCollection;

class IKMDataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return IKMData::all();
    }
}
