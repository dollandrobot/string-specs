<?php

declare(strict_types=1);

namespace App\Filament\Resources\StringSets\Pages;

use App\Filament\Resources\StringSets\StringSetResource;
use App\Models\StringSet;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

final class ListStringSets extends ListRecords
{
    protected static string $resource = StringSetResource::class;

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

        return $query->with(['brand', 'creator']);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
