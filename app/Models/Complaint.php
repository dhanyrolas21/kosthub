<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'room_id',
        'title',
        'description',
        'image',
        'status',
        'owner_notes',
    ];

    // Relasi ke Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Relasi ke Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}