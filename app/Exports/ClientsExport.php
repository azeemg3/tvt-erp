<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;

    public function __construct(?string $search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = Client::with('recoveryOfficerAccount');

        if (! empty($this->search)) {
            $term = '%'.$this->search.'%';
            $query->where(function ($q) use ($term) {
                $q->where('client_code', 'like', $term)
                    ->orWhere('client_name', 'like', $term)
                    ->orWhere('mobile', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('category', 'like', $term);
            });
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Client Code', 'Client Name', 'Mobile', 'Email', 'Category',
            'Credit Limit', 'Credit Days', 'Recovery Officer', 'Status',
        ];
    }

    public function map($client): array
    {
        return [
            $client->client_code,
            $client->client_name,
            $client->mobile,
            $client->email,
            $client->category,
            number_format((float) $client->credit_limit, 2),
            $client->credit_days,
            optional($client->recoveryOfficerAccount)->name,
            (int) $client->status === 1 ? 'Active' : 'Inactive',
        ];
    }
}
