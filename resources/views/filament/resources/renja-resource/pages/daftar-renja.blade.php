@php
    use Illuminate\Support\Str;
    use function Filament\Support\format_money;
@endphp

<x-filament-panels::page>
    @foreach($this->getRenjaWithRelations() as $program)
        <x-filament::section 
            collapsible
            icon="heroicon-o-clipboard-document-list"
            icon-color="success"
        >
            <x-slot name="heading">
                {{ $program->nama }}
            </x-slot>
            <x-slot name="headerEnd">
                <x-filament::badge
                    icon="heroicon-o-currency-dollar"
                    color="success"
                >
                    Anggaran
                </x-filament::badge>
                <p class="text-lg text-gray-600">
                @php
                    $anggaran_program = 0;
                    if($program->kegiatans->isNotEmpty()) {
                        foreach($program->kegiatans as $kegiatan) {
                            if($kegiatan->subkegiatans->isNotEmpty()) {
                                foreach($kegiatan->subkegiatans as $subkegiatan) {
                                    $subkegiatan->target_subkegiatan ? $anggaran_program += $subkegiatan->target_subkegiatan->anggaran : $anggaran_program += 0;
                                }
                            }
                        }
                        echo Str::replace('IDR', 'Rp', format_money($anggaran_program, 'IDR'));
                    }
                @endphp
                </p>
            </x-slot>
            <x-slot name="description">
                <b>Kode:</b> {{ $program->kode }} <br>
                <b>Indikator:</b>
                <ul>
                @foreach($program->target_programs as $target_program)
                    <li class="flex items-center">
                        <p class="ml-4 text-sm text-gray-600">{{ $loop->iteration }}. {{ $target_program->indikator }}</p>
                    </li>
                @endforeach
                </ul>
            </x-slot>

            @if($program->kegiatans->isNotEmpty())
                @foreach($program->kegiatans as $kegiatan)
                    <x-filament::section 
                        collapsible
                        icon="heroicon-o-clipboard-document-list"
                        icon-color="info"
                    >
                        <x-slot name="heading">
                            {{ $kegiatan->nama }}
                        </x-slot>
                        <x-slot name="headerEnd">
                            <x-filament::badge
                                icon="heroicon-o-currency-dollar"
                                color="success"
                            >
                                Anggaran
                            </x-filament::badge>
                            <p class="text-lg text-gray-600">
                            @php
                                $anggaran_kegiatan = 0;
                                if($kegiatan->subkegiatans->isNotEmpty()) {
                                    foreach($kegiatan->subkegiatans as $subkegiatan) {
                                        $subkegiatan->target_subkegiatan ? $anggaran_kegiatan += $subkegiatan->target_subkegiatan->anggaran : $anggaran_kegiatan += 0;
                                    }
                                }
                                echo Str::replace('IDR', 'Rp', format_money($anggaran_kegiatan, 'IDR'));
                            @endphp
                            </p>
                        </x-slot>
                        <x-slot name="description">
                            <b>Kode:</b> {{ $kegiatan->kode }} <br>
                            <b>Indikator:</b> {{ $kegiatan->target_kegiatan?->indikator }}
                        </x-slot>

                        @if($kegiatan->subkegiatans->isNotEmpty())
                            @foreach($kegiatan->subkegiatans as $subkegiatan)
                                <x-filament::section
                                    icon="heroicon-o-clipboard-document-list"
                                    icon-color="warning"
                                >
                                    <x-slot name="heading">
                                        {{ $subkegiatan->nama }}
                                    </x-slot>
                                    <x-slot name="headerEnd">
                                        <x-filament::badge
                                            icon="heroicon-o-currency-dollar"
                                            color="success"
                                        >
                                            Anggaran
                                        </x-filament::badge>
                                        {{ Str::replace('IDR', 'Rp', format_money($subkegiatan->target_subkegiatan ? $subkegiatan->target_subkegiatan->anggaran : 0, 'IDR')) }}
                                        @if(auth()->id() == $subkegiatan->user_id || auth()->id() == 1 || auth()->id() == 2)
                                            {{ ($this->editAction)(['target_subkegiatan' => $subkegiatan->target_subkegiatan->id]) }}
                                        @endif
                                    </x-slot>
                                    <x-slot name="description">
                                        <b>Kode:</b> {{ $subkegiatan->kode }} <br>
                                        <b>Indikator:</b> {{ $subkegiatan->target_subkegiatan?->indikator }}
                                    </x-slot>
                                </x-filament::section>
                                @if($loop->iteration != $loop->last)
                                    <br>
                                @endif
                            @endforeach
                        @else
                            Belum ada sub kegiatan
                        @endif
                    </x-filament::section>
                    @if($loop->iteration != $loop->last)
                        <br>
                    @endif
                @endforeach
            @else
                Belum ada kegiatan
            @endif
        </x-filament::section>
    @endforeach
    <x-filament-actions::modals />
</x-filament-panels::page>
