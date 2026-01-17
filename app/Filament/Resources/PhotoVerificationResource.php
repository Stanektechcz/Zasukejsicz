<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotoVerificationResource\Pages;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PhotoVerificationResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCamera;

    protected static ?int $navigationSort = 15;

    protected static ?string $slug = 'photo-verifications';

    public static function getNavigationLabel(): string
    {
        return __('filament.navigation.photo_verifications');
    }

    public static function getModelLabel(): string
    {
        return __('filament.pages.photo_verifications.photo');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.pages.photo_verifications.title');
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Media::query()
            ->where('collection_name', 'profile-images')
            ->whereJsonContains('custom_properties->verification_status', 'pending')
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('collection_name', 'profile-images')
            ->whereJsonContains('custom_properties->verification_status', 'pending')
            ->with(['model.user'])
            ->orderBy('created_at', 'asc');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('url')
                    ->label(__('filament.pages.photo_verifications.photo'))
                    ->getStateUsing(fn (Media $record): string => $record->getUrl())
                    ->height(120)
                    ->width(90),

                TextColumn::make('model.display_name')
                    ->label(__('filament.pages.photo_verifications.profile_name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('model.user.email')
                    ->label(__('filament.attributes.email'))
                    ->searchable(),

                TextColumn::make('custom_properties.is_main')
                    ->label(__('filament.pages.photo_verifications.main_photo'))
                    ->formatStateUsing(fn ($state) => $state ? '⭐ ' . __('filament.values.yes') : __('filament.values.no'))
                    ->badge()
                    ->color(fn ($state) => $state ? 'warning' : 'gray'),

                TextColumn::make('created_at')
                    ->label(__('filament.pages.photo_verifications.requested_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label(__('filament.pages.photo_verifications.approve'))
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading(__('filament.pages.photo_verifications.approve_confirm_title'))
                    ->modalDescription(__('filament.pages.photo_verifications.approve_confirm_desc'))
                    ->action(function (Media $record): void {
                        $record->setCustomProperty('verification_status', 'verified');
                        $record->setCustomProperty('verified_at', now()->toISOString());
                        $record->setCustomProperty('verified_by', auth()->id());
                        $record->save();

                        // Update profile verified_at if this is the main photo
                        if ($record->getCustomProperty('is_main', false) && $record->model) {
                            $record->model->update(['verified_at' => now()]);
                        }

                        Notification::make()
                            ->title(__('filament.pages.photo_verifications.approved'))
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label(__('filament.pages.photo_verifications.reject'))
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('filament.pages.photo_verifications.reject_confirm_title'))
                    ->modalDescription(__('filament.pages.photo_verifications.reject_confirm_desc'))
                    ->action(function (Media $record): void {
                        $record->setCustomProperty('verification_status', 'rejected');
                        $record->setCustomProperty('rejected_at', now()->toISOString());
                        $record->setCustomProperty('rejected_by', auth()->id());
                        $record->save();

                        // Clear profile verified_at if this is the main photo
                        if ($record->getCustomProperty('is_main', false) && $record->model) {
                            $record->model->update(['verified_at' => null]);
                        }

                        Notification::make()
                            ->title(__('filament.pages.photo_verifications.rejected'))
                            ->warning()
                            ->send();
                    }),

                ViewAction::make()
                    ->modalHeading(__('filament.pages.photo_verifications.review_photo')),
            ])
            ->bulkActions([
                BulkAction::make('approveSelected')
                    ->label(__('filament.pages.photo_verifications.approve_selected'))
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($records): void {
                        foreach ($records as $record) {
                            $record->setCustomProperty('verification_status', 'verified');
                            $record->setCustomProperty('verified_at', now()->toISOString());
                            $record->setCustomProperty('verified_by', auth()->id());
                            $record->save();

                            if ($record->getCustomProperty('is_main', false) && $record->model) {
                                $record->model->update(['verified_at' => now()]);
                            }
                        }

                        Notification::make()
                            ->title(__('filament.pages.photo_verifications.bulk_approved', ['count' => $records->count()]))
                            ->success()
                            ->send();
                    }),

                BulkAction::make('rejectSelected')
                    ->label(__('filament.pages.photo_verifications.reject_selected'))
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($records): void {
                        foreach ($records as $record) {
                            $record->setCustomProperty('verification_status', 'rejected');
                            $record->setCustomProperty('rejected_at', now()->toISOString());
                            $record->setCustomProperty('rejected_by', auth()->id());
                            $record->save();

                            if ($record->getCustomProperty('is_main', false) && $record->model) {
                                $record->model->update(['verified_at' => null]);
                            }
                        }

                        Notification::make()
                            ->title(__('filament.pages.photo_verifications.bulk_rejected', ['count' => $records->count()]))
                            ->warning()
                            ->send();
                    }),
            ])
            ->emptyStateHeading(__('filament.pages.photo_verifications.no_pending'))
            ->emptyStateDescription(__('filament.pages.photo_verifications.no_pending_desc'))
            ->emptyStateIcon(Heroicon::OutlinedCheckCircle);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('filament.pages.photo_verifications.photo'))
                    ->schema([
                        ImageEntry::make('url')
                            ->label('')
                            ->getStateUsing(fn (Media $record): string => $record->getUrl())
                            ->height(400),
                    ]),

                Section::make(__('filament.pages.photo_verifications.profile_info'))
                    ->schema([
                        TextEntry::make('model.display_name')
                            ->label(__('filament.pages.photo_verifications.profile_name')),

                        TextEntry::make('model.user.email')
                            ->label(__('filament.attributes.email')),

                        TextEntry::make('custom_properties.is_main')
                            ->label(__('filament.pages.photo_verifications.main_photo'))
                            ->formatStateUsing(fn ($state) => $state ? __('filament.values.yes') : __('filament.values.no'))
                            ->badge()
                            ->color(fn ($state) => $state ? 'warning' : 'gray'),

                        TextEntry::make('created_at')
                            ->label(__('filament.pages.photo_verifications.requested_at'))
                            ->dateTime('d.m.Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhotoVerifications::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }
}
