<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LogSystem extends Model
{
    use HasFactory;

    protected $table = 'systems';

    protected $fillable = [
        'name',
        'description',
        'api_path',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(LogEntry::class, 'system_id');
    }
}
