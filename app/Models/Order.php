<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "table_number",
        "client_name",
        "status",
        "completed_at",
    ];

    const STATUS_PENDING = "Pendiente";
    const STATUS_COMPLETED = "Completado";

    const STATUSES = [self::STATUS_PENDING, self::STATUS_COMPLETED];

    protected $withCount = ["foods"];

    public function finalize()
    {
        $this->update(["status" => self::STATUS_COMPLETED]);
    }

    public function isFinalized(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }
    
    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class)->withPivot("quantity");
    }

    public function scopeWithStatusPending($query)
    {
        return $query->where("status", self::STATUS_PENDING);
    }

    public function scopeWithStatusCompleted($query)
    {
        return $query->where("status", self::STATUS_COMPLETED);
    }
}
