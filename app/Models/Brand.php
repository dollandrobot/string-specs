<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CountryCode;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Brand extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'website',
        'logo_path',
        'country_code',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
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
            'website' => 'string',
            'logo_path' => 'string',
            'country_code' => CountryCode::class,
        ];
    }
}
