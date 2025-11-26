<?php

namespace App\Livewire;

use App\Exports\TransactionExport;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\PartnerUser;
use App\Models\Partner;
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
        $this->setAdditionalSelects([
            'transactions.id',
            'amount',
            'type',
            'komisi',
            'komisi_amount',
            'amount_after_komisi',
        ]);
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
            return Transaction::whereIn('merchant_id', $merchant_id)->with(['user', 'wallet.member', 'merchant.partner']);
        }
        if (Auth::user()->role == 'member') {
            $member_id = Member::where('user_id', Auth::user()->id)->pluck('id');
            $wallet_id = Wallet::where('member_id', $member_id)->pluck('id');
            return Transaction::whereIn('wallet_id', $wallet_id)->with(['user', 'wallet.member', 'merchant.partner']);
        }
        return Transaction::query()->with(['user', 'wallet.member', 'merchant.partner']);
    }

    public function filters(): array
    {

        $filters[] =  DateRangeFilter::make('Tanggal Transaksi')
            ->config([
                'allowInput' => true,
                'altFormat' => 'F j, Y',
                'ariaDateFormat' => 'F j, Y',
                'dateFormat' => 'Y-m-d',
                'earliestDate' => '2000-01-01',
                'latestDate' => today()->toDateString(),
                'placeholder' => 'Masukkan Rentang Tanggal',
                'locale' => 'id',
            ])
            ->setFilterPillValues([0 => 'minDate', 1 => 'maxDate'])
            ->filter(function (Builder $builder, array $dateRange) {
                $builder
                    ->whereDate('transactions.created_at', '>=', $dateRange['minDate'])
                    ->whereDate('transactions.created_at', '<=', $dateRange['maxDate']);
            });

        if (Auth::user()->role === 'admin') {
            $filters[] =
                SelectFilter::make('Tipe')
                ->options([
                    '' => 'Semua',
                    'payment' => 'Pembayaran',
                    'topup' => 'Top Up',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('type', $value);
                });

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
        $commissionLabel = "Potongan (RP)";
        if (Auth::user()->role === 'admin') {
            $commissionLabel = "Komisi (RP)";
        } elseif (Auth::user()->role === 'pengelola') {
            $partnerUser = PartnerUser::where('user_id', Auth::id())->first();
            if ($partnerUser) {
                $partner = Partner::find($partnerUser->partner_id);
                if ($partner && (int) $partner->status === 1) {
                    $commissionLabel = "Komisi (RP)";
                }
            }
        }

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
            Column::make($commissionLabel, "komisi_amount")
                ->label(fn($row) => 'Rp ' . number_format($row->komisi_amount, 0, ',', '.')),
            Column::make("Total", "amount_after_komisi")
                ->label(fn($row) => 'Rp ' . number_format($row->amount_after_komisi, 0, ',', '.'))
                ->footer(function ($rows) {
                    return $rows->sum('amount_after_komisi') ? 'Rp ' . number_format($rows->sum('amount_after_komisi'), 0, ',', '.') : 'Rp 0';
                }),
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
