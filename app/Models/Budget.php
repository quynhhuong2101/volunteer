<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'total_estimated', // Tổng dự trù
        'total_approved',  // Tổng được duyệt
        'total_spent',     // Tổng thực chi
        'status',          // 'draft', 'pending', 'approved', 'rejected'
        'admin_note',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function items()
    {
        return $this->hasMany(BudgetItem::class); // Chi tiết từng khoản
    }
}
