<?php

namespace App\Filament\Resources\RenjaResource\Pages;

use App\Exports\RenjasExport;
use App\Filament\Exports\RenjaExporter;
use Filament\Actions\Exports\Enums\ExportFormat;
use App\Filament\Resources\RenjaResource;
use App\Models\Aktivitas;
use App\Models\Program;
use App\Models\Target_subkegiatan;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Console\Concerns\InteractsWithIO;
use Maatwebsite\Excel\Facades\Excel;

class DaftarRenja extends Page
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Target_subkegiatan $target_subkegiatan;

    protected static string $resource = RenjaResource::class;

    protected static string $view = 'filament.resources.renja-resource.pages.daftar-renja';

    public function getRenjaWithRelations()
    {
        return Program::with('kegiatans.subkegiatans')->get();
    }

    public function getHeaderActions(): array
    {
        if(auth()->id() == 1 || auth()->id() == 2) {
            return [
                Action::make('export')
                    ->label('Export Excel')
                    ->color('success')
                    ->action('exportToExcel')
                    ->icon('heroicon-c-arrow-down-tray'),
            ];
        } else {
            return [];
        }
    }

    public function exportToExcel()
    {
        return Excel::download(new RenjasExport, 'Renja_2024.xlsx');
    }

    public function editAction(): Action
    {
        return EditAction::make()
            ->label('Edit')
            ->icon('heroicon-c-pencil-square')
            ->record(function (array $arguments) {
                // dump($arguments);
                return Target_subkegiatan::find($arguments['target_subkegiatan']);
            })
            ->form([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Kinerja')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('indikator')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-document-text')
                                    ->disabled(),
                                TextInput::make('kinerja')
                                    ->label('Target Kinerja')
                                    ->required()
                                    ->numeric()
                                    ->inputMode('decimal')
                                    ->prefixIcon('heroicon-o-key')
                                    ->disabled(),
                                Fieldset::make('Target Triwulan')
                                    ->schema([
                                        TextInput::make('k_tw1')
                                            ->label('TW 1')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('k_tw2')
                                            ->label('TW 2')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('k_tw3')
                                            ->label('TW 3')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('k_tw4')
                                            ->label('TW 4')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                    ])
                                    ->columns(4),
                                TextInput::make('satuan')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-percent-badge')
                                    ->disabled(),
                            ]),
                        Tabs\Tab::make('Anggaran')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                TextInput::make('anggaran')
                                    ->required()
                                    ->numeric()
                                    ->prefixIcon('heroicon-o-currency-dollar')
                                    ->disabled(),
                                Fieldset::make('Target Anggaran per Triwulan')
                                    ->schema([
                                        TextInput::make('a_tw1')
                                            ->label('TW 1')
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('a_tw2')
                                            ->label('TW 2')
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('a_tw3')
                                            ->label('TW 3')
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('a_tw4')
                                            ->label('TW 4')
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

    public function createAction(): Action
    {
        return CreateAction::make()
            ->label('Tambah')
            ->icon('heroicon-o-plus-circle')
            ->model(Aktivitas::class)
            ->form([
                Textarea::make('uraian')
                    ->required()
                    ->columnSpanFull(),
            ])
            ->mutateFormDataUsing(function (array $data, array $arguments): array {
                $data['subkegiatan_id'] = $arguments['subkegiatan'];

                return $data;
            });
    }
}
