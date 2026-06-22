<?php

namespace App\Exports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VendorsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;

    public function __construct(?string $search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = Vendor::query();

        if (! empty($this->search)) {
            $term = '%'.$this->search.'%';
            $query->where(function ($q) use ($term) {
                $q->where('vendor_code', 'like', $term)
                    ->orWhere('vendor_name', 'like', $term)
                    ->orWhere('vendor_type', 'like', $term)
                    ->orWhere('contact_person', 'like', $term)
                    ->orWhere('mobile', 'like', $term);
            });
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Vendor Code', 'Vendor Name', 'Vendor Type', 'Contact Person',
            'Mobile', 'Credit Limit', 'Credit Days', 'Status',
        ];
    }

    public function map($vendor): array
    {
        return [
            $vendor->vendor_code,
            $vendor->vendor_name,
            $vendor->vendor_type,
            $vendor->contact_person,
            $vendor->mobile,
            number_format((float) $vendor->credit_limit, 2),
            $vendor->credit_days,
            (int) $vendor->status === 1 ? 'Active' : 'Inactive',
        ];
    }
}
