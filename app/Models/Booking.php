<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_hp',
        'tanggal',
        'jam',
        'tanggal_selesai',
        'jam_selesai',
        'catatan',
        'status',
    ];

    public static function updateExpiredStatus(): void
    {
        $now = Carbon::now();
        $today = $now->toDateString();
        $currentTime = $now->toTimeString();

        self::whereIn('status', ['menunggu', 'disewa'])
            ->whereNotNull('tanggal_selesai')
            ->whereNotNull('jam_selesai')
            ->where(function ($query) use ($today, $currentTime) {
                $query->where('tanggal_selesai', '<', $today)
                    ->orWhere(function ($q) use ($today, $currentTime) {
                        $q->where('tanggal_selesai', '=', $today)
                            ->where('jam_selesai', '<=', $currentTime);
                    });
            })
            ->update(['status' => 'selesai']);

        self::where('status', 'menunggu')
            ->where(function ($query) use ($today, $currentTime) {
                $query->where('tanggal', '<', $today)
                    ->orWhere(function ($q) use ($today, $currentTime) {
                        $q->where('tanggal', '=', $today)
                            ->where('jam', '<=', $currentTime);
                    });
            })
            ->where(function ($query) use ($today, $currentTime) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>', $today)
                    ->orWhere(function ($q) use ($today, $currentTime) {
                        $q->where('tanggal_selesai', '=', $today)
                            ->where('jam_selesai', '>', $currentTime);
                    });
            })
            ->update(['status' => 'disewa']);
    }
}
