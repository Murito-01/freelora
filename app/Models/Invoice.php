<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

    protected $fillable = [
        'project_id',
        'number',
        'amount',
        'due_date',
    ];
    
    public function project() {

        return $this->belongsTo(Project::class);

    }
}
