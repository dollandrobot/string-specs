<?php

declare(strict_types=1);

namespace App\Filament\Resources\StringSets;

use App\Filament\Resources\StringSets\Pages\CreateStringSet;
use App\Filament\Resources\StringSets\Pages\EditStringSet;
use App\Filament\Resources\StringSets\Pages\ListStringSets;
use App\Filament\Resources\StringSets\Schemas\StringSetForm;
use App\Filament\Resources\StringSets\Tables\StringSetsTable;
use App\Models\StringSet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

final class StringSetResource extends Resource
{
    protected static ?string $model = StringSet::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return StringSetForm::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return StringSetsTable::configure($table);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStringSets::route('/'),
            'create' => CreateStringSet::route('/create'),
            'edit' => EditStringSet::route('/{record}/edit'),
        ];
    }
}
