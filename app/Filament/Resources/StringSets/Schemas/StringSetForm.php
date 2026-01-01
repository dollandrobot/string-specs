<?php

declare(strict_types=1);

namespace App\Filament\Resources\StringSets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class StringSetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('brand_id')
                    ->relationship('brand', 'name'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('product_code'),
                TextInput::make('winding_length')
                    ->numeric()
                    ->step(0.01),
                TextInput::make('number_of_strings')
                    ->numeric(),
                TextInput::make('high_gauge'),
                TextInput::make('low_gauge'),
            ]);
    }
}
