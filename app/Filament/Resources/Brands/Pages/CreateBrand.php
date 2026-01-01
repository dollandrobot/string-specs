<?php

declare(strict_types=1);

namespace App\Filament\Resources\Brands\Pages;

use App\Filament\Resources\Brands\BrandResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;

    #[Override]
    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
