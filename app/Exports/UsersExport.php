<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    protected $selectedIds;

    /**
     * Menerima array ID dari datatable
     */
    public function __construct(array $selectedIds)
    {
        $this->selectedIds = $selectedIds;
    }

    /**
     * Query data berdasarkan ID yang dipilih
     */
    public function query()
    {
        return User::orderBy('created_at', 'desc');;
    }

    /**
     * Menentukan nama kolom (header) di file Excel
     */
    public function headings(): array
    {
        return [
            'Username',
            'Hak Akses',
            'Tanggal Bergabung',
        ];
    }

    /**
     * Memetakan data untuk setiap baris
     * @param User $user
     */
    public function map($user): array
    {
        return [
            $user->username,
            $user->role,
            $user->created_at->format('d-m-Y H:i'),
        ];
    }
}
