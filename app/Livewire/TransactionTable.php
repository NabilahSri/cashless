<?php

namespace App\Livewire;

use App\Exports\TransactionExport;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\PartnerUser;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class TransactionTable extends DataTableComponent
{
    protected $model = Transaction::class;

    public function configure(): void
    {
        $this->setSortingPillsDisabled();
        $this->setDefaultSort('created_at', 'desc');
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['transactions.id', 'amount', 'type']);
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
        if (Auth::user()->role == 'member') {
            $member_id = Member::where('user_id', Auth::user()->id)->pluck('id');
            $wallet_id = Wallet::where('member_id', $member_id)->pluck('id');
            return Transaction::whereIn('wallet_id', $wallet_id)->with(['user', 'wallet.member']);
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

        $filters[] =  DateRangeFilter::make('Tanggal Transaksi')
            ->config([
                'allowInput' => true,  // Allow manual input of dates
                'altFormat' => 'F j, Y', // Date format that will be displayed once selected
                'ariaDateFormat' => 'F j, Y', // An aria-friendly date format
                'dateFormat' => 'Y-m-d', // Date format that will be received by the filter
                'earliestDate' => '2000-01-01', // The earliest acceptable date
                'latestDate' => today()->toDateString(), // PERBAIKAN: Menggunakan tanggal hari ini
                'placeholder' => 'Masukkan Rentang Tanggal', // PERBAIKAN: Diubah ke Bahasa Indonesia
                'locale' => 'id',
            ])
            ->setFilterPillValues([0 => 'minDate', 1 => 'maxDate']) // The values that will be displayed for the Min/Max Date Values
            ->filter(function (Builder $builder, array $dateRange) { // Expects an array.
                $builder
                    // PERBAIKAN: Menggunakan kolom 'created_at' dari tabel transaksi
                    ->whereDate('transactions.created_at', '>=', $dateRange['minDate']) // minDate is the start date selected
                    ->whereDate('transactions.created_at', '<=', $dateRange['maxDate']); // maxDate is the end date selected
            });

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
            Column::make("Tipe", "type")
                ->label(function ($row) {
                    if ($row->type === 'payment') {
                        return 'Pembayaran';
                    } elseif ($row->type === 'topup') {
                        return 'Top Up';
                    }
                }),
            Column::make("Nominal", "amount")
                ->label(fn($row) => 'Rp ' . number_format($row->amount, 0, ',', '.'))
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
