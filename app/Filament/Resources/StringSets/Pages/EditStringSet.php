<?php

declare(strict_types=1);

namespace App\Filament\Resources\StringSets\Pages;

use App\Filament\Resources\StringSets\StringSetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditStringSet extends EditRecord
{
    protected static string $resource = StringSetResource::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('brand');
    }

    #[Override]
    public function getHeading(): string
    {
        return sprintf('Edit %s %s', $this->record->brand?->name ?? 'Unknown', $this->record->name);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
