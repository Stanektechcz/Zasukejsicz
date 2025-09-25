<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = Auth::user();
        $isAdmin = $user && ($user->email === 'test@example.com'); // Temporary admin check

        // Available locales
        $locales = ['en', 'cs'];

        return $schema
            ->columns(2)
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->visible($isAdmin)
                    ->columnSpanFull(),

                Select::make('gender')
                    ->label(__('profiles.form.gender'))
                    ->options([
                        'male' => __('profiles.gender.male'),
                        'female' => __('profiles.gender.female'),
                    ])
                    ->required()
                    ->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Profile Images')
                    ->collection('profile-images')
                    ->multiple()
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                    ->maxFiles(10)
                    ->imageEditor()
                    ->columnSpanFull(),

                // Current locale translatable fields
                TextInput::make('display_name')
                    ->label(__('profiles.form.display_name') . ' (' . strtoupper(app()->getLocale()) . ')')
                    ->required()
                    ->maxLength(255)
                    ->afterStateHydrated(function (TextInput $component, $state, $record) {
                        if ($record && $record->exists) {
                            $currentLocale = app()->getLocale();
                            $component->state($record->getTranslation('display_name', $currentLocale));
                        }
                    }),

                MarkdownEditor::make('about')
                    ->label(__('profiles.form.about') . ' (' . strtoupper(app()->getLocale()) . ')')
                    ->maxLength(2000)
                    ->columnSpanFull()
                    ->afterStateHydrated(function (MarkdownEditor $component, $state, $record) {
                        if ($record && $record->exists) {
                            $currentLocale = app()->getLocale();
                            $component->state($record->getTranslation('about', $currentLocale));
                        }
                    }),

                TextInput::make('age')
                    ->label(__('profiles.form.age'))
                    ->numeric()
                    ->minValue(18)
                    ->maxValue(99),

                TextInput::make('city')
                    ->label(__('profiles.form.city'))
                    ->maxLength(255),

                TextInput::make('address')
                    ->label(__('profiles.form.address'))
                    ->maxLength(500)
                    ->columnSpanFull(),

                KeyValue::make('availability_hours')
                    ->label('Availability Hours')
                    ->keyLabel('Day')
                    ->valueLabel('Hours')
                    ->columnSpanFull()
                    ->helperText('Example: Monday -> 9:00-17:00'),

                Toggle::make('is_public')
                    ->label(__('profiles.form.is_public'))
                    ->default(true),

                Select::make('status')
                    ->label(__('profiles.form.status'))
                    ->options([
                        'draft' => __('profiles.status.draft'),
                        'pending' => __('profiles.status.pending'),
                        'approved' => __('profiles.status.approved'),
                        'rejected' => __('profiles.status.rejected'),
                    ])
                    ->default('draft')
                    ->visible($isAdmin),

                DateTimePicker::make('verified_at')
                    ->label('Verified At')
                    ->visible($isAdmin),
            ]);
    }
}
