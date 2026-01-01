<?php

declare(strict_types=1);

namespace App\Filament\Resources\Brands\Tables;

use App\Enums\CountryCode;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class BrandsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID')),
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('Brand Name')),
                TextColumn::make('website')
                    ->searchable()
                    ->label(__('Website URL')),
                ImageColumn::make('logo_path')
                    ->disk('public')
                    ->label(__('Brand Logo')),
                TextColumn::make('country_code')
                    ->formatStateUsing(fn (?string $code): string => ($code !== null) ? CountryCode::from($code)->value : '')
                    ->searchable()
                    ->label(__('Country Code')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('Created At')),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('Updated At')),
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
