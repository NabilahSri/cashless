<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Member;

class MemberTable extends DataTableComponent
{
    protected $model = Member::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            // Ambil nama dari relasi 'user'
            Column::make("Username", "user.username")
                ->sortable()
                ->searchable(),

            Column::make("Nama Member", "name")
                ->sortable()
                ->searchable(), // Tambahkan ini agar bisa dicari

            Column::make("Email", "email")
                ->sortable()
                ->searchable(),

            Column::make("No. Telp", "phone"),

            Column::make("Status", "status")
                ->sortable(),

            Column::make("Created at", "created_at")
                ->sortable(),

            Column::make('Aksi')
                ->label(
                    fn($row, Column $column) => view('livewire.datatable-actions')->with('row', $row)
                ),
        ];
    }
}
