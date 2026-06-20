<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogEntry extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'system_id',
        'level',
        'message',
        'received_at',
    ];

    protected function casts(): array
    {
        return [
            'received_at' => 'datetime',
        ];
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(LogSystem::class, 'system_id');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['system_id'] ?? null, fn (Builder $q, $systemId) => $q->where('system_id', $systemId))
            ->when($filters['level'] ?? null, fn (Builder $q, $level) => $q->where('level', $level))
            ->when($filters['date_from'] ?? null, fn (Builder $q, $from) => $q->where('received_at', '>=', $from))
            ->when($filters['date_to'] ?? null, fn (Builder $q, $to) => $q->where('received_at', '<=', $to))
            ->when(
                $filters['message'] ?? null,
                fn (Builder $q, $message) => $q->where('message', 'like', '%'.$message.'%')
            );
    }
}
