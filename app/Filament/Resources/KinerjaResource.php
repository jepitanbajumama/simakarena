<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KinerjaResource\Pages;
use App\Filament\Resources\KinerjaResource\RelationManagers;
use App\Filament\Resources\ProgramResource\Pages\CreateProgramKegiatan;
use App\Models\Program;
use App\Models\Renja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KinerjaResource extends Resource
{
    // protected static ?string $model = Renja::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationLabel = 'Kinerja';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Realisasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            // 'index' => Pages\ListKinerjas::route('/'),
            // 'view' => Pages\ViewKinerja::route('/{record}'),
            'index' => Pages\DaftarKinerja::route('/'),
        ];
    }
}
