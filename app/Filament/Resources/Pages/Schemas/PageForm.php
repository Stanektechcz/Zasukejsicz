<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use SkyRaptor\FilamentBlocksBuilder\Blocks;
use SkyRaptor\FilamentBlocksBuilder\Forms\Components\BlocksInput;
use Illuminate\Support\Str;
use App\Filament\Blocks\Faq;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->label(__('pages.form.title') . ' (' . strtoupper(app()->getLocale()) . ')')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                    ->afterStateHydrated(function (TextInput $component, $state, $record) {
                        if ($record && $record->exists) {
                            $currentLocale = app()->getLocale();
                            $component->state($record->getTranslation('title', $currentLocale));
                        }
                    })
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->label(__('pages.form.slug'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText(__('pages.form.slug_helper'))
                    ->prefix(url('/') . '/')
                    ->columnSpanFull(),

                Radio::make('type')
                    ->label(__('pages.form.type'))
                    ->options([
                        'page' => __('pages.form.type_page'),
                        'blog' => __('pages.form.type_blog'),
                    ])
                    ->default('page')
                    ->required()
                    ->inline()
                    ->helperText(__('pages.form.type_helper'))
                    ->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('header_image')
                    ->label(__('pages.form.header_image'))
                    ->collection('header-image')
                    ->image()
                    ->imageEditor()
                    ->maxSize(5120)
                    ->helperText(__('pages.form.header_image_helper'))
                    ->visible(fn ($get) => $get('type') === 'blog')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label(__('pages.form.description') . ' (' . strtoupper(app()->getLocale()) . ')')
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText(__('pages.form.description_helper'))
                    ->visible(fn ($get) => $get('type') === 'blog')
                    ->afterStateHydrated(function (Textarea $component, $state, $record) {
                        if ($record && $record->exists) {
                            $currentLocale = app()->getLocale();
                            $component->state($record->getTranslation('description', $currentLocale));
                        }
                    })
                    ->columnSpanFull(),

                BlocksInput::make('content')
                    ->label(__('pages.form.content') . ' (' . strtoupper(app()->getLocale()) . ')')
                    ->blocks(fn() => [
                        Blocks\Typography\Heading::block($schema),
                        Blocks\Typography\Paragraph::block($schema),
                        Blocks\Card::block($schema),
                        Faq::block($schema),
                    ])
                    ->afterStateHydrated(function (BlocksInput $component, $state, $record) {
                        if ($record && $record->exists) {
                            $currentLocale = app()->getLocale();
                            $component->state($record->getTranslation('content', $currentLocale));
                        }
                    })
                    ->columnSpanFull()
                    ->helperText(__('pages.form.content_helper')),

                Toggle::make('display_in_menu')
                    ->label(__('pages.form.display_in_menu'))
                    ->helperText(__('pages.form.display_in_menu_helper'))
                    ->default(false),

                Toggle::make('is_published')
                    ->label(__('pages.form.is_published'))
                    ->helperText(__('pages.form.is_published_helper'))
                    ->default(true),
            ]);
    }
}
