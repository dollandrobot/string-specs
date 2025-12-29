<?php

declare(strict_types=1);

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()->label(__('Brand Name')),
                TextInput::make('website')
                    ->url()->nullable()->label(__('Website URL')),
                FileUpload::make('logo_path')->label(__('Brand Logo'))
                    ->image()
                    ->nullable()
                    ->directory('brand-logos')
                    ->maxSize(1024)
                    ->imageResizeMode('contain')
                    ->imageCropAspectRatio('1:1'),
                TextInput::make('country_code')->maxLength(2)->nullable()->label(__('Country Code')),
            ]);
    }
}
