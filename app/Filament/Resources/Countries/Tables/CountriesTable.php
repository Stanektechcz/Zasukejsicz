<?php

namespace App\Filament\Resources\Countries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('flag_image')
                    ->label('Flag')
                    ->collection('flag-images')
                    ->conversion('medium')
                    ->size(40)
                    ->circular(),
                
                TextColumn::make('country_name')
                    ->label('Country Name')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->getTranslation('country_name', app()->getLocale());
                    }),
                
                TextColumn::make('country_code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                
                TextColumn::make('profiles_count')
                    ->label('Profiles')
                    ->counts('profiles')
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
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
            ])
            ->defaultSort('country_name');
    }
}
