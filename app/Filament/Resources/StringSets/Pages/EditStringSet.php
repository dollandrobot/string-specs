<?php

declare(strict_types=1);

namespace App\Filament\Resources\StringSets\Pages;

use App\Filament\Resources\StringSets\StringSetResource;
use App\Models\StringSet;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use Override;

/**
 * @extends EditRecord<StringSet>
 */
final class EditStringSet extends EditRecord
{
    protected static string $resource = StringSetResource::class;

    #[Override]
    public function getHeading(): string
    {
        /** @var StringSet $record */
        $record = $this->record;

        return sprintf('Edit %s %s', $record->brand->name ?? 'Unknown', $record->name);
    }

    /**
     * @return Builder<StringSet>
     *
     * @phpstan-return Builder<StringSet>
     *
     * @codeCoverageIgnore
     */
    protected function getEloquentQuery(): Builder
    {
        /** @var Builder<StringSet> $query */
        $query = parent::getEloquentQuery();

        return $query->with('brand');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
