<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromQuery, WithHeadings, WithMapping
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
        return Transaction::with(['user', 'wallet.member'])->whereIn('id', $this->selectedIds)->orderBy('created_at', 'desc');;
    }
    /**
     * Menentukan nama kolom (header) di file Excel
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Member',
            'Transaksi ID',
            'Pengelola',
            'Tipe Transaksi',
            'Nominal',
        ];
    }


    public function map($transaction): array
    {
        return [
            $transaction->created_at->format('d-m-Y'),
            $transaction->wallet->member->name ?? 'N/A',
            $transaction->trx_id,
            $transaction->user->name ?? 'N/A',
            $transaction->type,
            $transaction->amount,
        ];
    }
}
