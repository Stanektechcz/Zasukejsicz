<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // Current locale translatable field
                TextInput::make('name')
                    ->label('Service Name (' . strtoupper(app()->getLocale()) . ')')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->afterStateHydrated(function (TextInput $component, $state, $record) {
                        if ($record && $record->exists) {
                            $currentLocale = app()->getLocale();
                            $component->state($record->getTranslation('name', $currentLocale));
                        }
                    }),

                // Current locale translatable field
                Textarea::make('description')
                    ->label('Description (' . strtoupper(app()->getLocale()) . ')')
                    ->rows(3)
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->afterStateHydrated(function (Textarea $component, $state, $record) {
                        if ($record && $record->exists) {
                            $currentLocale = app()->getLocale();
                            $component->state($record->getTranslation('description', $currentLocale));
                        }
                    }),

                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->helperText('Lower numbers appear first'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Inactive services won\'t be visible to users'),
            ]);
    }
}


