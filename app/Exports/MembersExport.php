<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersExport implements FromQuery, WithHeadings, WithMapping
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
        return Member::with('user')->whereIn('id', $this->selectedIds)->orderBy('created_at', 'desc');;
    }

    /**
     * Menentukan nama kolom (header) di file Excel
     */
    public function headings(): array
    {
        return [
            'No. Member',
            'Nama',
            'Username',
            'Email',
            'No. Telp',
            'Status',
            'UID Kartu',
            'Alamat',
            'Tanggal Bergabung',
        ];
    }

    /**
     * Memetakan data untuk setiap baris
     * @param Member $member
     */
    public function map($member): array
    {
        return [
            $member->member_no,
            $member->name,
            $member->user->username ?? 'N/A',
            $member->email ?? 'N/A',
            $member->phone,
            $member->status ?? 'N/A',
            $member->card_uid,
            $member->address,
            $member->created_at->format('d-m-Y H:i'),
        ];
    }
}
