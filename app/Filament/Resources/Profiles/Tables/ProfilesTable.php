<?php

namespace App\Filament\Resources\Profiles\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_name')
                    ->label(__('profiles.table.display_name'))
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        $currentLocale = app()->getLocale();
                        $fallbackLocale = config('app.fallback_locale', 'en');
                        
                        // Try to get translation for current locale, fallback to English if not available
                        return $record->getTranslation('display_name', $currentLocale) 
                            ?: $record->getTranslation('display_name', $fallbackLocale)
                            ?: $record->display_name; // Final fallback
                    }),

                TextColumn::make('user.name')
                    ->label(__('profiles.table.user'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('gender')
                    ->label(__('profiles.table.gender'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'blue',
                        'female' => 'pink',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => __("profiles.gender.{$state}")),

                TextColumn::make('age')
                    ->label(__('profiles.table.age'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('city')
                    ->label(__('profiles.table.city'))
                    ->searchable(),

                TextColumn::make('about')
                    ->label(__('profiles.table.about'))
                    ->limit(50)
                    ->getStateUsing(function ($record) {
                        $currentLocale = app()->getLocale();
                        $fallbackLocale = config('app.fallback_locale', 'en');
                        
                        // Try to get translation for current locale, fallback to English if not available
                        return $record->getTranslation('about', $currentLocale) 
                            ?: $record->getTranslation('about', $fallbackLocale)
                            ?: $record->about; // Final fallback
                    })
                    ->tooltip(function ($record) {
                        $currentLocale = app()->getLocale();
                        $fallbackLocale = config('app.fallback_locale', 'en');
                        
                        return $record->getTranslation('about', $currentLocale) 
                            ?: $record->getTranslation('about', $fallbackLocale)
                            ?: $record->about;
                    })
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('profiles.table.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("profiles.status.{$state}")),

                IconColumn::make('is_public')
                    ->label(__('profiles.table.public'))
                    ->boolean(),

                IconColumn::make('verified_at')
                    ->label(__('profiles.table.verified'))
                    ->boolean()
                    ->getStateUsing(fn ($record) => !is_null($record->verified_at))
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),

                TextColumn::make('created_at')
                    ->label(__('profiles.table.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('profiles.table.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('profiles.filters.status'))
                    ->options([
                        'draft' => __('profiles.status.draft'),
                        'pending' => __('profiles.status.pending'),
                        'approved' => __('profiles.status.approved'),
                        'rejected' => __('profiles.status.rejected'),
                    ]),

                SelectFilter::make('city')
                    ->label(__('profiles.filters.city'))
                    ->searchable()
                    ->options(function () {
                        return \App\Models\Profile::whereNotNull('city')
                            ->pluck('city', 'city')
                            ->unique()
                            ->sort();
                    }),

                SelectFilter::make('gender')
                    ->label(__('profiles.filters.gender'))
                    ->options([
                        'male' => __('profiles.gender.male'),
                        'female' => __('profiles.gender.female'),
                    ]),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('verify')
                    ->label(__('profiles.actions.verify'))
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(fn ($record) => $record->markAsVerified())
                    ->visible(fn ($record) => !$record->isVerified())
                    ->requiresConfirmation(),
                
                Action::make('unverify')
                    ->label(__('profiles.actions.unverify'))
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(fn ($record) => $record->markAsUnverified())
                    ->visible(fn ($record) => $record->isVerified())
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
