<?php

namespace App\Livewire;

use App\Models\PartnerUser;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PengelolaTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSortingPillsDisabled();
        $this->setDefaultSort('created_at', 'desc');
        $this->setAdditionalSelects(['id']);
    }

    public function builder(): Builder
    {
        $partner_id = PartnerUser::where('user_id', Auth::user()->id)->pluck('partner_id');
        $pengelola = PartnerUser::where('partner_id', $partner_id)->pluck('user_id');
        return User::whereIn('id', $pengelola);
    }

    public function columns(): array
    {
        return [
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Username", "username")
                ->searchable(),
            Column::make("Hak Akses", "role")
                ->format(fn($value) => $value === 'admin' ? 'Administrator' : 'Pengelola'),
            Column::make("Tanggal Bergabung", "created_at")
                ->sortable(),
            Column::make('Aksi')
                ->label(
                    fn($row) =>
                    view('livewire.datatable-actions')
                        ->with('row', $row)
                        ->with('editEvent', 'open-edit-pengelola')
                        ->with('editUrl', null)
                        ->with('viewUrl', null)
                        ->with('delete', true)
                ),
        ];
    }
}
