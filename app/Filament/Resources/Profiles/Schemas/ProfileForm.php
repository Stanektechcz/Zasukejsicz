<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = Auth::user();
        $isAdmin = $user && $user->roles()->where('name', 'admin')->exists();

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
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('display_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('age')
                    ->numeric()
                    ->minValue(18)
                    ->maxValue(99),

                TextInput::make('city')
                    ->maxLength(255),

                TextInput::make('address')
                    ->maxLength(500)
                    ->columnSpanFull(),

                MarkdownEditor::make('about')
                    ->maxLength(2000)
                    ->columnSpanFull(),

                KeyValue::make('availability_hours')
                    ->label('Availability Hours')
                    ->keyLabel('Day')
                    ->valueLabel('Hours')
                    ->columnSpanFull()
                    ->helperText('Example: Monday -> 9:00-17:00'),

                Toggle::make('is_public')
                    ->label('Public Profile')
                    ->default(true),

                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'pending' => 'Pending Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('draft')
                    ->visible($isAdmin),

                DateTimePicker::make('verified_at')
                    ->label('Verified At')
                    ->visible($isAdmin),
            ]);
    }
}
