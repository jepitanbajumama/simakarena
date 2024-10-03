<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Filament\Resources\ProgramResource\RelationManagers;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Ancestor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Guava\FilamentNestedResources\Concerns\NestedResource;
use Illuminate\Database\Eloquent\Model;

use function Filament\Support\format_money;

class ProgramResource extends Resource
{
    use NestedResource;

    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationLabel = 'Kelola Renja';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->label('Kode Program')
                    ->prefixIcon('heroicon-o-qr-code'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Uraian Program')
                    ->prefixIcon('heroicon-o-document-text'),
                // Forms\Components\TextInput::make('indikator')
                //     ->required()
                //     ->label('Indikator Program'),
                // Forms\Components\TextInput::make('satuan')
                //     ->required()
                //     ->label('Satuan Program'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode'),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Uraian Program'),
                Tables\Columns\TextColumn::make('target_programs.indikator')
                    ->label('Indikator')
                    ->listWithLineBreaks()
                    ->placeholder('Belum ditentukan'),
                Tables\Columns\TextColumn::make('target_programs.kinerja')
                    ->label('Target Kinerja')
                    ->listWithLineBreaks()
                    ->placeholder('Belum ditentukan'),
                Tables\Columns\TextColumn::make('target_programs.satuan')
                    ->label('Satuan')
                    ->listWithLineBreaks()
                    ->placeholder('Belum ditentukan'),
                Tables\Columns\TextColumn::make('target_subkegiatans_sum_anggaran')
                    ->label('Anggaran')
                    ->getStateUsing(function ($record) {
                        $anggaran = $record->kegiatans()
                            ->with('subkegiatans.target_subkegiatan')
                            ->get()
                            ->flatMap(fn($kegiatan) => $kegiatan->subkegiatans)
                            ->sum(fn($subkegiatan) => $subkegiatan->target_subkegiatan->anggaran ?? 0);
                        return Str::replace('IDR', 'Rp', format_money($anggaran, 'IDR'));
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TargetProgramsRelationManager::class,
            RelationManagers\KegiatansRelationManager::class,
        ];
    }

    public static function getAncestor(): ?Ancestor
    {
        return null;
    }

    public static function getBreadcrumbRecordLabel(Model $record)
    {
        return $record->nama;
    }

    public static function getPages(): array
    {
        return [
            // Program
            'index' => Pages\ListPrograms::route('/'),
            // 'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),

            // Needed to create child records
            // The name should be '{relationshipName}.create':
            'kegiatans.create' => Pages\CreateProgramKegiatan::route('/{record}/kegiatans/create'),
        ];
    }
}
