<?php

namespace App\Livewire;

use App\Exports\TransactionExport;
use App\Models\Merchant;
use App\Models\PartnerUser;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::user()->role == 'pengelola') {
            $partner_id = PartnerUser::where('user_id', Auth::user()->id)->pluck('partner_id');
            $merchant_id = Merchant::where('partner_id', $partner_id)->pluck('id');
            return Transaction::whereIn('merchant_id', $merchant_id)->with(['user', 'wallet.member']);
        }
        return Transaction::query()->with(['user', 'wallet.member']);
    }

    public function filters(): array
    {
        $filters = [
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

        if (Auth::user()->role === 'admin') {
            $filters[] = SelectFilter::make('Pengelola')
                ->options([
                    '' => 'Semua',
                ] + User::where('role', 'pengelola')
                    ->pluck('name', 'id')
                    ->toArray())
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('transactions.user_id', $value);
                });
        }

        return $filters;
    }


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
