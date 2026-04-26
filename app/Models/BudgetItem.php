<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    protected $fillable = ['budget_id', 'name', 'unit_price', 'quantity', 'source'];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
