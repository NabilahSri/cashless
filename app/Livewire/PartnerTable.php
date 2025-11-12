<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Partner;
use App\Models\PartnerUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class PartnerTable extends DataTableComponent
{
    protected $model = Partner::class;

    public function configure(): void
    {
        $this->setSortingPillsDisabled();
        $this->setDefaultSort('created_at', 'desc');
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['id', 'status']);
    }

    public function builder(): Builder
    {
        if (Auth::user()->role == 'pengelola') {
            $partner_id = PartnerUser::where('user_id', Auth::user()->id)->pluck('partner_id');
            return Partner::where('id', $partner_id);
        }
        return Partner::query();
    }

    public function columns(): array
    {
        return [
            Column::make("Nama", "name")
                ->searchable()
                ->sortable(),
            Column::make("Email", "email")
                ->searchable(),
            Column::make("No. Telp", "phone")
                ->searchable(),
            Column::make("Alamat", "address"),
            Column::make("Tanggal Bergabung", "created_at")
                ->sortable(),
            Column::make('status', 'status')
                ->label(fn($row) => $row->status == 1 ? 'Default' : '-'),
            Column::make('Aksi')
                ->label(
                    fn($row) =>
                    view('livewire.datatable-actions')
                        ->with('row', $row)
                        ->with('editEvent', null)
                        ->with('editUrl', route('partner.edit', $row))
                        ->with('viewEvent', 'open-view-partner')
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
            $partnerUser = PartnerUser::where('partner_id', $id)->get();
            $partnerUser->each->delete();
            $partner = Partner::findOrFail($id);
            $partner->delete();
            $this->dispatch('success', message: 'Member berhasil dihapus.');
        } catch (\Exception $e) {
            $this->dispatch('failed', message: $e->getMessage());
        }
    }
}
