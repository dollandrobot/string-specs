<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class StringSet extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'brand_id',
        'name',
        'product_code',
        'winding_length',
        'number_of_strings',
        'high_gauge',
        'low_gauge',
        'created_by',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'name' => 'string',
            'product_code' => 'string',
            'number_of_strings' => 'integer',
            'high_gauge' => 'integer',
            'low_gauge' => 'integer',
        ];
    }
}
