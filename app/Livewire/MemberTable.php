<?php

namespace App\Livewire;

use App\Exports\MembersExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class MemberTable extends DataTableComponent
{
    protected $model = Member::class;

    public function configure(): void
    {
        $this->setSortingPillsDisabled();
        $this->setDefaultSort('created_at', 'desc');
        $this->setPrimaryKey('id');
        $this->setBulkActions([
            'exportSelected' => 'Download Data (Excel)',
            'activateSelected' => 'Aktifkan Pilihan',
            'deactivateSelected' => 'Non-Aktifkan Pilihan',
        ]);
        $this->setAdditionalSelects(['status_member', 'members.id']);
    }

    public function builder(): Builder
    {
        return Member::query();
    }

    public function columns(): array
    {
        return [
            Column::make("No. Member", "member_no")
                ->sortable()
                ->searchable(),

            Column::make("Nama Member", "name")
                ->sortable()
                ->searchable(),

            Column::make("Username", "user.username")
                ->sortable()
                ->searchable(),

            Column::make("Email", "email")
                ->sortable()
                ->searchable(),

            Column::make("No. Telp", "phone"),

            Column::make("Status", "status_member")
                ->sortable()
                ->label(function ($row) {
                    return $row->status_member === 'active'
                        ? '<span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">Aktif</span>'
                        : '<span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-200">Tidak Aktif</span>';
                })
                ->html(),

            Column::make("Tanggal Bergabung", "created_at")
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

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status_filter')
                ->options([
                    '' => 'Semua',
                    'active' => 'Aktif',
                    'inactive' => 'Non-Aktif',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === 'active') {
                        $builder->where('status_member', 'active');
                    } elseif ($value === 'inactive') {
                        $builder->where('status_member', 'inactive');
                    }
                }),
        ];
    }

    public function exportSelected()
    {
        if (count($this->getSelected()) === 0) {
            $this->dispatch('failed', message: 'Tidak ada data yang dipilih.');
            return;
        }

        $filename = 'Export member -' . now()->format('YmdHis') . '.xlsx';

        $this->clearSelected();
        return Excel::download(new MembersExport($this->getSelected()), $filename);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    #[On('delete-confirmed')]
    public function deleteConfirmed($id)
    {
        try {
            $member = Member::findOrFail($id);
            $member->delete();
            $this->dispatch('success', message: 'Member berhasil dihapus.');
        } catch (\Exception $e) {
            $this->dispatch('failed', message: $e->getMessage());
        }
    }

    public function activateSelected()
    {
        if (count($this->getSelected()) === 0) {
            $this->dispatch('failed', message: 'Tidak ada data yang dipilih.');
            return;
        }

        Member::whereIn('id', $this->getSelected())->update(['status_member' => 'active']);
        $this->dispatch('success', message: 'Status member berhasil diubah menjadi Aktif.');
        $this->clearSelected();
    }

    public function deactivateSelected()
    {
        if (count($this->getSelected()) === 0) {
            $this->dispatch('failed', message: 'Tidak ada data yang dipilih.');
            return;
        }

        Member::whereIn('id', $this->getSelected())->update(['status_member' => 'inactive']);
        $this->clearSelected();
        $this->dispatch('success', message: 'Status member berhasil diubah menjadi Non-Aktif.');
    }
}
