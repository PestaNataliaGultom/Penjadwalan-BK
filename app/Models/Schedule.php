<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_id',
        'schedule_date',
        'from_time',
        'to_time',
        'duration',
        'status',
        'notes',
    ];

    protected $appends = ['status_badge'];

    public function getStatusBadgeAttribute(): string
    {
        if ($this->status == 1) {
            return '<span class="badge bg-success">Sudah di ACC</span>';
        }elseif ($this->status == 2) {
            return '<span class="badge bg-danger">Ditolak</span>';
        }
        return '<span class="badge bg-info">Belum di ACC</span>';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id')->whereHas('roles', function($q){
            $q->where('name', 'Guru Bk');
        });
    }

  /**
   * Get the output associated with the Schedule
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function outputSchedule(): HasOne
  {
      return $this->hasOne(ScheduleOutput::class, 'schedule_id', 'id');
  }
}
