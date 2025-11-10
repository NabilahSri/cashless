<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class MerchantTable extends DataTableComponent
{
    protected $model = Merchant::class;

    public function configure(): void
    {
        $this->setSortingPillsDisabled();
        $this->setDefaultSort('created_at', 'desc');
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['merchants.id']);
    }

    public function builder(): Builder
    {
        return Merchant::query();
    }

    public function columns(): array
    {
        return [
            Column::make("Nama", "name")
                ->searchable()
                ->sortable(),
            Column::make("Partner", "partner.name")
                ->searchable()
                ->sortable(),
            Column::make("Tanggal Dibuat", "created_at")
                ->sortable(),
            Column::make('Aksi')
                ->label(
                    fn($row) =>
                    view('livewire.datatable-actions')
                        ->with('row', $row)
                        ->with('editUrl', route('member.edit', $row))
                        ->with('viewUrl', null)
                        ->with('delete', true)
                ),
        ];
    }
}
