<?php

declare(strict_types=1);

namespace App\Filament\Resources\StringSets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class StringSetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('product_code')
                    ->searchable(),
                TextColumn::make('winding_length')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('number_of_strings')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('highest_string_gauge')
                    ->searchable(),
                TextColumn::make('lowest_string_gauge')
                    ->searchable(),
                TextColumn::make('creator.name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
