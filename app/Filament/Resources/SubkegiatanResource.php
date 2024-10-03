<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubkegiatanResource\Pages;
use App\Filament\Resources\SubkegiatanResource\RelationManagers;
use App\Models\Subkegiatan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Ancestor;
use Guava\FilamentNestedResources\Concerns\NestedResource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use function Filament\Support\format_money;

class SubkegiatanResource extends Resource
{
    use NestedResource;

    protected static ?string $model = Subkegiatan::class;

    // protected static ?string $navigationIcon = 'heroicon-m-bars-3-bottom-left';
    // protected static ?string $navigationLabel = 'Kelola Renja';
    // protected static ?int $navigationSort = 2;
    // protected static ?string $navigationGroup = 'Master Data';
    // protected static bool $shouldRegisterNavigation = false;

    public static string $parentResource = KegiatanResource::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->label('Kode Sub Kegiatan')
                    ->prefixIcon('heroicon-o-qr-code'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Uraian Sub Kegiatan')
                    ->prefixIcon('heroicon-o-document-text'),
                Forms\Components\Select::make('user_id')
                    ->label('Bidang Pengampu')
                    ->required()
                    ->options(User::all()->pluck('name', 'id')),
            ]);
    }

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->nama;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('kegiatan.nama_kegiatan')
                //     ->label('Kegiatan'),
                // Tables\Columns\TextColumn::make('kode_subkegiatan')
                //     ->label('Kode Sub Kegiatan'),
                // Tables\Columns\TextColumn::make('nama_subkegiatan')
                //     ->label('Uraian Sub Kegiatan'),
                // Tables\Columns\TextColumn::make('indikator_subkegiatan')
                //     ->label('Indikator'),
                // Tables\Columns\TextColumn::make('target_subkegiatan.kinerja')
                //     ->label('Target Kinerja')
                //     ->placeholder('Belum ditentukan'),
                // Tables\Columns\TextColumn::make('satuan_subkegiatan')
                //     ->label('Satuan'),
                // Tables\Columns\TextColumn::make('target_subkegiatan.anggaran')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                'kegiatan.nama_kegiatan',
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TargetSubkegiatansRelationManager::class,
            RelationManagers\AktivitasRelationManager::class,
        ];
    }

    public static function getBreadcrumbRecordLabel(Model $record)
    {
        return $record->nama;
    }

    public static function getAncestor(): ?Ancestor
    {
        // Configure the ancestor (parent) relationship here
        return Ancestor::make(
            'subkegiatans', // Relationship name
            'kegiatan', // Inverse relationship name
        );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubkegiatans::route('/'),
            'create' => Pages\CreateSubkegiatan::route('/create'),
            'edit' => Pages\EditSubkegiatan::route('/{record}/edit'),
        ];
    }
}
