<?php

namespace App\Exports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RenjasExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Program::all();


        // Fetch programs with related kegiatans and subkegiatans
        return Program::with(['kegiatans.subkegiatans', 'target_programs']) // Eager load related models
            ->get()
            ->flatMap(function ($program) {
            
            $rows = [];
            
            // Calculate anggaran program
            $anggaranProgram = $program->kegiatans->flatMap(function ($kegiatan) {
                return $kegiatan->subkegiatans->map(function ($subkegiatan) {
                    return $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->anggaran : 0;
                });
            })->sum();
            
            // Add the program name to the first row
            $rows[] = [
                'Kode' => $program->kode,
                'Uraian' => $program->nama,
                'Indikator' => $program->target_programs ? $program->target_programs->pluck('indikator')->implode(', ') : 'N/A',
                'Satuan' => $program->target_programs ? $program->target_programs->pluck('satuan')->implode(', ') : 'N/A',
                'Kinerja' => $program->target_programs ? $program->target_programs->pluck('kinerja')->implode(', ') : 'N/A',
                'Anggaran' => $anggaranProgram,
            ];

            // Iterate over related kegiatans
            foreach ($program->kegiatans as $kegiatan) {
                // Calculate anggaran kegiatan
                $anggaranKegiatan = $kegiatan->subkegiatans->map(function ($subkegiatan) {
                    return $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->anggaran : 0;
                })->sum();

                $rows[] = [
                    'Kode' => $kegiatan->kode,
                    'Uraian' => $kegiatan->nama,
                    'Indikator' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->indikator : 'N/A',
                    'Satuan' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->satuan : 'N/A',
                    'Kinerja' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->kinerja : 'N/A',
                    'Anggaran' => $anggaranKegiatan,
                ];

                // Iterate over related subkegiatans
                foreach ($kegiatan->subkegiatans as $subkegiatan) {
                    $rows[] = [
                        'Kode' => $subkegiatan->kode,
                        'Uraian' => $subkegiatan->nama,
                        'Indikator' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->indikator : 'N/A',
                        'Satuan' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->satuan : 'N/A',
                        'Kinerja' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->kinerja : 'N/A',
                        'Anggaran' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->anggaran : '0',
                    ];
                }
            }

            return $rows;
        });
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Uraian Program/Kegiatan/Sub Kegiatan',
            'Indikator',
            'Satuan',
            'Target Kinerja',
            'Anggaran',
        ];
    }
}
