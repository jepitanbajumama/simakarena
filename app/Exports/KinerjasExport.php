<?php

namespace App\Exports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KinerjasExport implements FromCollection, WithHeadings
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
                'Target TW I' => $program->target_programs ? $program->target_programs->pluck('k_tw1')->implode(', ') : 'N/A',
                'Realisasi TW I' => $program->target_programs ? $program->target_programs->pluck('r_k_tw1')->implode(', ') : 'N/A',
                'Target TW II' => $program->target_programs ? $program->target_programs->pluck('k_tw2')->implode(', ') : 'N/A',
                'Realisasi TW II' => $program->target_programs ? $program->target_programs->pluck('r_k_tw2')->implode(', ') : 'N/A',
                'Target TW III' => $program->target_programs ? $program->target_programs->pluck('k_tw3')->implode(', ') : 'N/A',
                'Realisasi TW III' => $program->target_programs ? $program->target_programs->pluck('r_k_tw3')->implode(', ') : 'N/A',
                'Target TW IV' => $program->target_programs ? $program->target_programs->pluck('k_tw4')->implode(', ') : 'N/A',
                'Realisasi TW IV' => $program->target_programs ? $program->target_programs->pluck('r_k_tw4')->implode(', ') : 'N/A',
                'Capaian' => 0,
            ];

            // Iterate over related kegiatans
            foreach ($program->kegiatans as $kegiatan) {
                $rows[] = [
                    'Kode' => $kegiatan->kode,
                    'Uraian' => $kegiatan->nama,
                    'Indikator' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->indikator : 'N/A',
                    'Satuan' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->satuan : 'N/A',
                    'Kinerja' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->kinerja : 'N/A',
                    'Target TW I' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->k_tw1 : 'N/A',
                    'Realisasi TW I' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->r_k_tw1 : 'N/A',
                    'Target TW II' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->k_tw2 : 'N/A',
                    'Realisasi TW II' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->r_k_tw2 : 'N/A',
                    'Target TW III' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->k_tw3 : 'N/A',
                    'Realisasi TW III' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->r_k_tw3 : 'N/A',
                    'Target TW IV' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->k_tw4 : 'N/A',
                    'Realisasi TW IV' => $kegiatan->target_kegiatan ? $kegiatan->target_kegiatan->r_k_tw4 : 'N/A',
                    'Capaian' => 0,
                ];

                // Iterate over related subkegiatans
                foreach ($kegiatan->subkegiatans as $subkegiatan) {
                    // Calculate Capaian Kinerja
                    if($subkegiatan->target_subkegiatan->kinerja == 0 || $subkegiatan->target_subkegiatan->kinerja == null) {
                        $capaianKinerja = 0;
                    } else {
                        $capaianKinerja = ($subkegiatan->target_subkegiatan->r_k_tw1 + $subkegiatan->target_subkegiatan->r_k_tw2 + $subkegiatan->target_subkegiatan->r_k_tw3 + $subkegiatan->target_subkegiatan->r_k_tw4) / $subkegiatan->target_subkegiatan->kinerja;
                    }


                    $rows[] = [
                        'Kode' => $subkegiatan->kode,
                        'Uraian' => $subkegiatan->nama,
                        'Indikator' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->indikator : 'N/A',
                        'Satuan' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->satuan : 'N/A',
                        'Kinerja' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->kinerja : 'N/A',
                        'Target TW I' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->k_tw1 : 'N/A',
                        'Realisasi TW I' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->r_k_tw1 : 'N/A',
                        'Target TW II' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->k_tw2 : 'N/A',
                        'Realisasi TW II' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->r_k_tw2 : 'N/A',
                        'Target TW III' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->k_tw3 : 'N/A',
                        'Realisasi TW III' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->r_k_tw3 : 'N/A',
                        'Target TW IV' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->k_tw4 : 'N/A',
                        'Realisasi TW IV' => $subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->r_k_tw4 : 'N/A',
                        'Capaian' => $capaianKinerja,
                        'Aktivitas' => $subkegiatan->aktivitas ? $subkegiatan->aktivitas->pluck('uraian')->implode(', ') : 'N/A',
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
            'Target Kinerja Tahun',
            'Target TW I',
            'Realisasi TW I',
            'Target TW II',
            'Realisasi TW II',
            'Target TW III',
            'Realisasi TW III',
            'Target TW IV',
            'Realisasi TW IV',
            'Capaian (%)',
            'Aktivitas',
        ];
    }
}
