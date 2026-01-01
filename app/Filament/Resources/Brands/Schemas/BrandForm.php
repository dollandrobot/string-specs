<?php

declare(strict_types=1);

namespace App\Filament\Resources\Brands\Schemas;

use App\Enums\CountryCode;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->unique(ignoreRecord: true)
                    ->required()->label(__('Brand Name')),
                TextInput::make('website')
                    ->url()->nullable()->label(__('Website URL')),
                FileUpload::make('logo_path')->label(__('Brand Logo'))
                    ->image()
                    ->nullable()
                    ->disk('public')
                    ->directory('brand-logos')
                    ->maxSize(1024)
                    ->imageResizeMode('contain')
                    ->imageCropAspectRatio('1:1'),
                Select::make('country_code')
                    ->nullable()
                    ->label(__('Country'))
                    ->enum(CountryCode::class)
                    ->options(collect(CountryCode::cases())->mapWithKeys(fn (CountryCode $country): array => [
                        $country->value => $country->label().' ('.$country->value.')',
                    ]))
                    ->searchable()
                    ->helperText(__('Select a country from the list')),
            ]);
    }
}
