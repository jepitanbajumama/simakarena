<?php

namespace App\Filament\Exports;

use App\Models\Program;
// use App\Models\Renja;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RenjaExporter extends Exporter
{
    protected static ?string $model = Program::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('kode_program'),
            ExportColumn::make('nama_program'),
            ExportColumn::make('indikator_program'),
            ExportColumn::make('target_program.kinerja'),
            ExportColumn::make('satuan_program'),
            ExportColumn::make('kegiatans.kode_kegiatan'),
            ExportColumn::make('kegiatans.nama_kegiatan'),
            ExportColumn::make('kegiatans.indikator_kegiatan'),
            ExportColumn::make('kegiatans.satuan_kegiatan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your renja export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
