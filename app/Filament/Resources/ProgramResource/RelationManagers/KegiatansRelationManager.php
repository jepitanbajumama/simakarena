<?php

namespace App\Filament\Resources\ProgramResource\RelationManagers;

use App\Filament\Resources\KegiatanResource;
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

class KegiatansRelationManager extends RelationManager
{
    use NestedRelationManager;
    public static string $nestedResource = KegiatanResource::class;
    protected static ?string $title = "Daftar Kegiatan";

    protected static string $relationship = 'kegiatans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
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
                    ->label('Kode Kegiatan'),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Uraian Kegiatan'),
                Tables\Columns\TextColumn::make('target_kegiatan.indikator')
                    ->label('Indikator')
                    ->placeholder('Belum ditentukan'),
                Tables\Columns\TextColumn::make('target_kegiatan.kinerja')
                    ->label('Target Kinerja')
                    ->placeholder('Belum ditentukan'),
                Tables\Columns\TextColumn::make('target_kegiatan.satuan')
                    ->label('Satuan')
                    ->placeholder('Belum ditentukan'),
                Tables\Columns\TextColumn::make('target_subkegiatans_sum_anggaran')
                    ->label('Anggaran')
                    ->getStateUsing(function ($record) {
                        $anggaran = $record->subkegiatans()
                            ->withSum('target_subkegiatan', 'anggaran')
                            ->get()
                            ->sum('target_subkegiatan_sum_anggaran');
                        return Str::replace('IDR', 'Rp', format_money($anggaran, 'IDR'));
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Kegiatan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
