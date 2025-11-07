<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait WithLogsActivity
{
    use LogsActivity;

    /**
     * Tentukan field mana yang mau dicatat oleh Spatie
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('cashless_activity')
            ->setDescriptionForEvent(fn(string $eventName) => $this->getCashlessDescription($eventName));
    }

    /**
     * Tambahkan informasi tambahan seperti IP, device, browser, dll
     */
    public function tapActivity(Activity $activity, string $eventName)
    {
        $agent = new Agent();
        $user = Auth::user();

        $activity->causer_id = $user->id ?? null;
        $activity->causer_type = $user ? get_class($user) : null;
        $activity->ip_address = request()->ip();
        $activity->device = $agent->device();
        $activity->platform = $agent->platform();
        $activity->browser = $agent->browser();
    }

    /**
     * Generate deskripsi berdasarkan jenis event (cashless context)
     */
    protected function getCashlessDescription(string $eventName): string
    {
        $modelName = class_basename($this);
        $recordId = $this->id ?? 'unknown';

        $eventDescriptions = [
            'created' => "Menambahkan data baru untuk {$modelName}.",
            'updated' => "Memperbarui data {$modelName} (ID: {$recordId}).",
            'deleted' => "Menghapus data {$modelName} (ID: {$recordId}).",
        ];

        // Khusus untuk transaksi cashless
        if ($modelName === 'Transaction') {
            $eventDescriptions = [
                'created' => "Transaksi baru berhasil dibuat (ID: {$recordId}).",
                'updated' => "Status transaksi telah diperbarui (ID: {$recordId}).",
                'deleted' => "Transaksi telah dihapus (ID: {$recordId}).",
            ];
        }

        // Khusus untuk user atau top-up
        if ($modelName === 'User') {
            $eventDescriptions['updated'] = "Profil pengguna diperbarui.";
        }

        return $eventDescriptions[$eventName] ?? "Aksi {$eventName} dilakukan pada {$modelName}.";
    }
}
