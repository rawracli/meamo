<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Template extends Model
{
    protected $fillable = [
        'name',
        'image',
        'template_category_id',
        'description',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            TemplateCategory::class,
            'template_category_id'
        );
    }
}
