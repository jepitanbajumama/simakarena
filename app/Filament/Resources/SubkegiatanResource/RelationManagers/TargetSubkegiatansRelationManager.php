<?php

namespace App\Filament\Resources\SubkegiatanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use function Filament\Support\format_money;

class TargetSubkegiatansRelationManager extends RelationManager
{
    protected static string $relationship = 'target_subkegiatan';
    protected static ?string $title = 'Kinerja Sub Kegiatan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Kinerja')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('indikator')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-document-text'),
                                Forms\Components\TextInput::make('kinerja')
                                    ->label('Target Kinerja')
                                    ->required()
                                    ->maxLength(255)
                                    ->numeric()
                                    ->inputMode('decimal')
                                    ->prefixIcon('heroicon-o-key'),
                                Fieldset::make('Target Triwulan')
                                    ->schema([
                                        Forms\Components\TextInput::make('k_tw1')
                                            ->label('TW 1')
                                            ->maxLength(255)
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                        Forms\Components\TextInput::make('k_tw2')
                                            ->label('TW 2')
                                            ->maxLength(255)
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                        Forms\Components\TextInput::make('k_tw3')
                                            ->label('TW 3')
                                            ->maxLength(255)
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                        Forms\Components\TextInput::make('k_tw4')
                                            ->label('TW 4')
                                            ->maxLength(255)
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                    ])
                                    ->columns(4),
                                Forms\Components\TextInput::make('satuan')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-percent-badge'),
                            ]),
                        Tabs\Tab::make('Anggaran')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\TextInput::make('anggaran')
                                    ->required()
                                    ->numeric()
                                    ->prefixIcon('heroicon-o-currency-dollar'),
                                Fieldset::make('Target Anggaran per Triwulan')
                                    ->schema([
                                        Forms\Components\TextInput::make('a_tw1')
                                            ->label('TW 1')
                                            ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                        Forms\Components\TextInput::make('a_tw2')
                                            ->label('TW 2')
                                            ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                        Forms\Components\TextInput::make('a_tw3')
                                            ->label('TW 3')
                                            ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                        Forms\Components\TextInput::make('a_tw4')
                                            ->label('TW 4')
                                            ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->contained(false)
                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('indikator')
            ->columns([
                Tables\Columns\TextColumn::make('indikator'),
                Tables\Columns\TextColumn::make('kinerja')
                    ->label('Target Kinerja'),
                Tables\Columns\TextColumn::make('k_tw1')
                    ->label('TW 1')
                    ->placeholder('Kosong'),
                Tables\Columns\TextColumn::make('k_tw2')
                    ->label('TW 2')
                    ->placeholder('Kosong'),
                Tables\Columns\TextColumn::make('k_tw3')
                    ->label('TW 3')
                    ->placeholder('Kosong'),
                Tables\Columns\TextColumn::make('k_tw4')
                    ->label('TW 4')
                    ->placeholder('Kosong'),
                Tables\Columns\TextColumn::make('satuan')
                    ->label('Satuan'),
                Tables\Columns\TextColumn::make('anggaran')
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Tambah Target Sub Kegiatan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
