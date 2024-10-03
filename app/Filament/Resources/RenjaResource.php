<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RenjaResource\Pages;
use App\Filament\Resources\RenjaResource\RelationManagers;
use App\Models\Program;
use App\Models\Renja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use function Filament\Support\format_money;

class RenjaResource extends Resource
{
    // protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Rencana Kerja';
    protected static ?int $navigationSort = 2;

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
            // 'index' => Pages\ListRenjas::route('/'),
            // 'view' => Pages\ViewRenja::route('/{record}'),
            'index' => Pages\DaftarRenja::route('/'),
        ];
    }
}
