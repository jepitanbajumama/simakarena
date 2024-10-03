<?php

namespace App\Filament\Resources\KegiatanResource\RelationManagers;

use App\Filament\Resources\SubkegiatanResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Concerns\NestedRelationManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use function Filament\Support\format_money;

class SubkegiatansRelationManager extends RelationManager
{
    use NestedRelationManager;
    public static string $nestedResource = SubkegiatanResource::class;
    protected static ?string $title = 'Daftar Sub Kegiatan';

    protected static string $relationship = 'subkegiatans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_subkegiatan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->label('Kode Sub Kegiatan'),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Uraian Sub Kegiatan'),
                Tables\Columns\TextColumn::make('target_subkegiatan.indikator')
                    ->label('Indikator')
                    ->placeholder('Belum ditentukan'),
                Tables\Columns\TextColumn::make('target_subkegiatan.kinerja')
                    ->label('Target Kinerja')
                    ->placeholder('Belum ditentukan'),
                Tables\Columns\TextColumn::make('target_subkegiatan.satuan')
                    ->label('Satuan')
                    ->placeholder('Belum ditentukan'),
                Tables\Columns\TextColumn::make('target_subkegiatan.anggaran')
                    ->label('Anggaran')
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })
                    ->placeholder('Belum Ditentukan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Sub Kegiatan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
