<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Builder;

class WalletTable extends DataTableComponent
{
    protected $model = Wallet::class;

    public function configure(): void
    {
        $this->setSortingPillsDisabled();
        $this->setDefaultSort('created_at', 'desc');
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['wallets.id', 'balance']);
    }

    public function builder(): Builder
    {
        return Wallet::query()->where('member.status', 'active');
    }

    public function columns(): array
    {
        return [
            Column::make("Nama", "member.name")
                ->searchable()
                ->sortable(),
            Column::make("Saldo", "balance")
                ->sortable()
                ->label(fn($row) => 'Rp ' . number_format($row->balance, 0, ',', '.')),
            Column::make("Terakhir Topup", "last_topup_at")
                ->sortable(),
            Column::make("Tanggal Dibuat", "created_at")
                ->sortable(),
        ];
    }
}
