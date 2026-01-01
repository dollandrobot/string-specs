<?php

declare(strict_types=1);

namespace App\Filament\Resources\StringSets\Pages;

use App\Filament\Resources\StringSets\StringSetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListStringSets extends ListRecords
{
    protected static string $resource = StringSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
