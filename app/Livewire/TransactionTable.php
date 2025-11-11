<?php

namespace App\Livewire;

use App\Exports\TransactionExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class TransactionTable extends DataTableComponent
{
    protected $model = Transaction::class;

    public function configure(): void
    {
        $this->setSortingPillsDisabled();
        $this->setDefaultSort('created_at', 'desc');
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['transactions.id']);
        $this->setFilterLayout('slide-down');
        $this->setBulkActions([
            'exportSelected' => 'Download Data (Excel)',
        ]);
    }

    public function builder(): Builder
    {
        return Transaction::query()->with(['user', 'wallet.member']);
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Pengelola') // Nama yang tampil di UI
                ->options([
                    '' => 'Semua', // Opsi default untuk menampilkan semua
                ] + User::where('role', 'pengelola')->get()->pluck('name', 'id')->toArray()) // Mengambil data user
                ->filter(function (Builder $builder, string $value) {
                    // Logika yang dijalankan saat filter dipilih
                    $builder->where('user_id', $value);
                }),

            SelectFilter::make('Tipe')
                ->options([
                    '' => 'Semua',
                    'payment' => 'Pembayaran',
                    'topup' => 'Top Up',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('type', $value);
                }),
        ];
    }
    // --- AKHIR TAMBAHAN ---

    public function columns(): array
    {
        return [
            Column::make("Tanggal", "created_at")
                ->sortable(),
            Column::make("Nama Member", "wallet.member.name")
                ->searchable(),
            Column::make("Transaksi ID", "trx_id")
                ->sortable()
                ->searchable(),
            Column::make("Pengelola", "user.name")
                ->searchable(),
            Column::make("Tipe", "type"),
            Column::make("Nominal", "amount")
                ->sortable(),
        ];
    }

    public function exportSelected()
    {
        if (count($this->getSelected()) === 0) {
            $this->dispatch('failed', message: 'Tidak ada data yang dipilih.');
            return;
        }

        $filename = 'Export transaksi -' . now()->format('YmdHis') . '.xlsx';

        return Excel::download(new TransactionExport($this->getSelected()), $filename);
        $this->clearSelected();
    }
}
