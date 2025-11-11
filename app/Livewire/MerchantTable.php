<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class MerchantTable extends DataTableComponent
{
    protected $model = Merchant::class;


    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSortingPillsDisabled();
        $this->setDefaultSort('created_at', 'desc');
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
                        ->with('editEvent', 'open-edit-merchant')
                        ->with('editUrl', null)
                        ->with('viewUrl', null)
                        ->with('delete', true)
                ),
        ];
    }
    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    #[On('delete-confirmed')]
    public function deleteConfirmed($id)
    {
        try {
            $merchant = Merchant::findOrFail($id);
            $merchant->delete();
            $this->dispatch('success', message: 'Merchant berhasil dihapus.');
        } catch (\Exception $e) {
            $this->dispatch('failed', message: $e->getMessage());
        }
    }
}
