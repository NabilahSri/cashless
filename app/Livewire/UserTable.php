<?php

namespace App\Livewire;

use App\Exports\UsersExport;
use App\Models\PartnerUser;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class UserTable extends DataTableComponent
{
    protected $model = User::class;


    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSortingPillsDisabled();
        $this->setDefaultSort('created_at', 'desc');
        $this->setAdditionalSelects(['id']);
        $this->setBulkActions([
            'exportSelected' => 'Download Data (Excel)',
        ]);
    }

    public function builder(): Builder
    {
        return User::query()
            ->whereIn('role', ['admin', 'pengelola']);
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
                        ->with('editEvent', 'open-edit-user')
                        ->with('editUrl', null)
                        ->with('viewUrl', null)
                        ->with('delete', true)
                ),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Role', 'role_filter')
                ->options([
                    '' => 'Semua',
                    'admin' => 'Administrator',
                    'pengelola' => 'Pengelola',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === 'admin') {
                        $builder->where('role', 'admin');
                    } elseif ($value === 'pengelola') {
                        $builder->where('role', 'pengelola');
                    }
                }),
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
            $member = User::findOrFail($id);
            $member->delete();
            $this->dispatch('success', message: 'User berhasil dihapus.');
        } catch (\Exception $e) {
            $this->dispatch('failed', message: $e->getMessage());
        }
    }

    public function exportSelected()
    {
        if (count($this->getSelected()) === 0) {
            $this->dispatch('failed', message: 'Tidak ada data yang dipilih.');
            return;
        }

        $filename = 'Export member -' . now()->format('YmdHis') . '.xlsx';

        $this->clearSelected();
        return Excel::download(new UsersExport($this->getSelected()), $filename);
    }
}
