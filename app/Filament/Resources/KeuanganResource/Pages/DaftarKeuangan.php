<?php

namespace App\Filament\Resources\KeuanganResource\Pages;

use App\Exports\KeuangansExport;
use App\Filament\Resources\KeuanganResource;
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
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Maatwebsite\Excel\Facades\Excel;

class DaftarKeuangan extends Page
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Target_subkegiatan $target_subkegiatan;

    protected static string $resource = KeuanganResource::class;

    protected static string $view = 'filament.resources.keuangan-resource.pages.daftar-keuangan';

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
        return Excel::download(new KeuangansExport, 'Keuangan_2024.xlsx');
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
                        Tabs\Tab::make('Realisasi Anggaran')
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
                                            // ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key')
                                            ->disabled(),
                                        TextInput::make('a_tw2')
                                            ->label('TW 2')
                                            // ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key')
                                            ->disabled(),
                                        TextInput::make('a_tw3')
                                            ->label('TW 3')
                                            // ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key')
                                            ->disabled(),
                                        TextInput::make('a_tw4')
                                            ->label('TW 4')
                                            // ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key')
                                            ->disabled(),
                                    ])
                                    ->columns(2),
                                Fieldset::make('Realisasi Anggaran per Triwulan')
                                    ->schema([
                                        TextInput::make('r_a_tw1')
                                            ->label('TW 1')
                                            // ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('r_a_tw2')
                                            ->label('TW 2')
                                            // ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('r_a_tw3')
                                            ->label('TW 3')
                                            // ->maxLength(255)
                                            ->numeric()
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('r_a_tw4')
                                            ->label('TW 4')
                                            // ->maxLength(255)
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
