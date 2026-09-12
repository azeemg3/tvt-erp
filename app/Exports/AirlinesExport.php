<?php

namespace App\Exports;

use App\Models\Airline;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AirlinesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;

    public function __construct(?string $search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = Airline::with('countryInfo');

        if (! empty($this->search)) {
            $term = '%'.$this->search.'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('iata_code', 'like', $term)
                    ->orWhere('icao_code', 'like', $term)
                    ->orWhere('numeric_code', 'like', $term)
                    ->orWhereHas('countryInfo', function ($countryQuery) use ($term) {
                        $countryQuery->where('name', 'like', $term);
                    });
            });
        }

        return $query->orderBy('name')->get();
    }

    public function headings(): array
    {
        return ['Airline Name', 'IATA', 'ICAO', 'Numeric Code', 'Country', 'Status'];
    }

    public function map($airline): array
    {
        return [
            $airline->name,
            $airline->iata_code,
            $airline->icao_code,
            $airline->numeric_code,
            optional($airline->countryInfo)->name,
            (int) $airline->status === 1 ? 'Active' : 'Inactive',
        ];
    }
}
