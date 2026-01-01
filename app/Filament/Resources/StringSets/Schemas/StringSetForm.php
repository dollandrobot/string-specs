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
                    ->relationship('brand', 'name')
                    ->required()
                    ->label(__('Brand')),
                TextInput::make('name')
                    ->required(),
                TextInput::make('product_code'),
                TextInput::make('winding_length')
                    ->numeric()
                    ->step(1)
                    ->minValue(100)
                    ->maxValue(6000),
                TextInput::make('number_of_strings')
                    ->integer()
                    ->minValue(1)
                    ->maxValue(18),
                TextInput::make('highest_string_gauge')
                    ->integer()
                    ->minValue(1)
                    ->maxValue(200),
                TextInput::make('lowest_string_gauge')
                    ->integer()
                    ->minValue(1)
                    ->maxValue(200)
                    ->gt('highest_string_gauge'),
            ]);
    }
}
