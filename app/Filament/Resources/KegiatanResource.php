<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanResource\Pages;
use App\Filament\Resources\KegiatanResource\RelationManagers;
use App\Models\Kegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Ancestor;
use Guava\FilamentNestedResources\Concerns\NestedResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use function Filament\Support\format_money;

class KegiatanResource extends Resource
{
    use NestedResource;
    
    protected static ?string $model = Kegiatan::class;

    // protected static ?string $navigationIcon = 'heroicon-m-bars-3-bottom-left';
    // protected static ?string $navigationLabel = 'Kelola Renja';
    // protected static ?int $navigationSort = 2;
    // protected static ?string $navigationGroup = 'Master Data';
    // protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->label('Kode Kegiatan')
                    ->prefixIcon('heroicon-o-qr-code'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Uraian Kegiatan')
                    ->prefixIcon('heroicon-o-document-text'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('program.nama_program'),
                Tables\Columns\TextColumn::make('kode_kegiatan'),
                Tables\Columns\TextColumn::make('nama_kegiatan')
                    ->label('Uraian Kegiatan'),
                // Tables\Columns\TextColumn::make('indikator_kegiatan')
                //     ->label('Indikator'),
                // Tables\Columns\TextColumn::make('target_kegiatan.kinerja')
                //     ->label('Target Kinerja')
                //     ->placeholder('Belum ditentukan'),
                // Tables\Columns\TextColumn::make('satuan_kegiatan')
                //     ->label('Satuan'),
                // Tables\Columns\TextColumn::make('target_kegiatan.anggaran')
                //     ->label('Anggaran')
                //     ->placeholder('Belum ditentukan')
                //     ->formatStateUsing(function ($state) {
                //         return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                //     }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TargetKegiatansRelationManager::class,
            RelationManagers\SubkegiatansRelationManager::class,
        ];
    }

    public static function getAncestor(): ?Ancestor
    {
        // Configure the ancestor (parent) relationship here
        return Ancestor::make(
            'kegiatans', // Relationship name
            'program', // Inverse relationship name
        );
    }

    public static function getBreadcrumbRecordLabel(Model $record)
    {
        return $record->nama;
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKegiatans::route('/'),
            'create' => Pages\CreateKegiatan::route('/create'),
            'edit' => Pages\EditKegiatan::route('/{record}/edit'),

            // Needed to create child records
            // The name should be '{relationshipName}.create':
            'subkegiatans.create' => Pages\CreateKegiatanSubkegiatan::route('/{record}/subkegiatans/create'),
        ];
    }
}
