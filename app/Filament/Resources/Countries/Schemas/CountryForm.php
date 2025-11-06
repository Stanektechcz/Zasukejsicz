<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('country_name.cs')
                    ->label('Country Name (Czech)')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('country_name.en')
                    ->label('Country Name (English)')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('country_code')
                    ->label('Country Code')
                    ->required()
                    ->maxLength(3)
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g., CZ, SK, DE')
                    ->helperText('ISO country code (2-3 characters)')
                    ->columnSpanFull(),
                
                SpatieMediaLibraryFileUpload::make('flag_image')
                    ->label('Flag Image')
                    ->collection('flag-images')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                    ->maxSize(2048)
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('64')
                    ->imageResizeTargetHeight('64')
                    ->disk('public')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->helperText('Upload a flag image for this country (max 2MB, will be resized to 64x64px)'),
            ]);
    }
}
