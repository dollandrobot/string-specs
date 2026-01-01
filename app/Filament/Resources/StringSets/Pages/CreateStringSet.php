<?php

declare(strict_types=1);

namespace App\Filament\Resources\StringSets\Pages;

use App\Filament\Resources\StringSets\StringSetResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateStringSet extends CreateRecord
{
    protected static string $resource = StringSetResource::class;

    #[Override]
    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
