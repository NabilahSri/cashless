<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\LogActivity;
use Illuminate\Database\Eloquent\Builder;

class LogActivityTable extends DataTableComponent
{
    protected $model = LogActivity::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setSortingPillsDisabled();
        $this->setAdditionalSelects(['properties', 'activity_log.id']);
    }

    public function build(): Builder
    {
        return LogActivity::query();
    }

    public function columns(): array
    {
        return [
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Event", "event"),
            Column::make("Description", "description")->view('livewire.log-activity.description-cell'),
            Column::make("User", "causer.name"),
            Column::make("Subject Type", "subject_type"),
            Column::make("IP Address", "ip_address"),
            Column::make("Device", "device"),
            Column::make("Platform", "platform"),
            Column::make("Browser", "browser"),

        ];
    }
}
