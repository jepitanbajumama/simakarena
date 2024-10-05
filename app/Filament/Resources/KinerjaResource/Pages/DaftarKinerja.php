<?php

namespace App\Filament\Resources\KinerjaResource\Pages;

use App\Exports\KinerjasExport;
use App\Filament\Resources\KinerjaResource;
use App\Models\Aktivitas;
use App\Models\Program;
use App\Models\Target_subkegiatan;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Resources\Pages\Page;
use Maatwebsite\Excel\Facades\Excel;

class DaftarKinerja extends Page
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Target_subkegiatan $target_subkegiatan;

    protected static string $resource = KinerjaResource::class;

    protected static string $view = 'filament.resources.kinerja-resource.pages.daftar-kinerja';

    public function getRenjaWithRelations()
    {
        $userId = auth()->id();

        if($userId == 1 || $userId == 2) {
            // Admin and PEP
            return Program::with('kegiatans.subkegiatans')->get();
        } else {
            // User Bidang
            return Program::whereHas('kegiatans.subkegiatans', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->with([
                'kegiatans' => function($query) use ($userId) {
                    $query->whereHas('subkegiatans', function ($subQuery) use ($userId) {
                        $subQuery->where('user_id', $userId);
                    });
                },
                'kegiatans.subkegiatans' => function($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ])->get();
        }
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
        return Excel::download(new KinerjasExport, 'Kinerja_2024.xlsx');
    }

    public function editTargetsubkegiatanAction(): Action
    {
        return EditAction::make('editTargetsubkegiatan')
            ->label('Edit')
            ->modalHeading('Realisasi Sub Kegiatan')
            ->icon('heroicon-c-pencil-square')
            ->record(function (array $arguments) {
                // dump($arguments);
                return Target_subkegiatan::find($arguments['target_subkegiatan']);
            })
            ->form([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Realisasi Kinerja')
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
                                            ->prefixIcon('heroicon-o-key')
                                            ->disabled(),
                                        TextInput::make('k_tw2')
                                            ->label('TW 2')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key')
                                            ->disabled(),
                                        TextInput::make('k_tw3')
                                            ->label('TW 3')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key')
                                            ->disabled(),
                                        TextInput::make('k_tw4')
                                            ->label('TW 4')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key')
                                            ->disabled(),
                                    ])
                                    ->columns(4),
                                Fieldset::make('Realisasi Kinerja')
                                    ->schema([
                                        TextInput::make('r_k_tw1')
                                            ->label('TW 1')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('r_k_tw2')
                                            ->label('TW 2')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('r_k_tw3')
                                            ->label('TW 3')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-key'),
                                        TextInput::make('r_k_tw4')
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
                    ])
                    ->columnSpanFull()
                    ->contained(false)
            ]);
    }

    public function editAktivitasAction(): Action
    {
        return EditAction::make('editAktivitas')
            ->label('Edit')
            ->color('warning')
            ->modalHeading('Edit Aktivitas')
            ->icon('heroicon-c-pencil-square')
            ->record(function (array $arguments) {
                return Aktivitas::find($arguments['aktivitas']);
            })
            ->form([
                Textarea::make('uraian')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function createAction(): Action
    {
        return CreateAction::make()
            ->label('Tambah')
            ->color('success')
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

    public function deleteAktivitasAction(): Action
    {
        return DeleteAction::make('deleteAktivitas')
            ->label('Hapus')
            ->color('danger')
            ->icon('heroicon-s-trash')
            ->record(function (array $arguments) {
                return Aktivitas::find($arguments['aktivitas']);
            });
    }
}
