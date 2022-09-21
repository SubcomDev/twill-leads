<?php

namespace Leads\Twill\Capsules\Leads\Exports;

use Leads\Twill\Capsules\Leads\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeadExport implements FromCollection, WithHeadings, WithMapping
{
    public $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $leads = new Lead();

        if (count($this->ids) > 0) {
            $leads = $leads->whereIn('id', $this->ids);
        }

        return $leads->get();
    }

    public function headings(): array
    {
        return [['Email','Created_at']];
    }

    public function map($lids): array
    {
        return [
            $lids->email,
            $lids->created_at->format('d, m, Y, h:m:s'),
        ];
    }
}