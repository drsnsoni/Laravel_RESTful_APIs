<?php

namespace App\Models;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'is_done', 'project_id'];

    protected $cast = [
        'is_done' => 'boolean'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function cretor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'craetor_id');
    }
    public function project():BelongsTo{
        return $this->belongsTo(Project::class);
    }
    protected static function booted():void
    {
        static::addGlobalScope('creator', function(Builder $builder) {
            $builder->where('creator_id', Auth::id());
        });
    }
}
