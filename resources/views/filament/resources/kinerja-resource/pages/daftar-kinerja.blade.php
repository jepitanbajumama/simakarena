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
                    icon="heroicon-o-arrow-trending-up"
                    color="warning"
                >
                    Kinerja
                </x-filament::badge>
                <p class="text-lg text-gray-600">
                @foreach($program->target_programs as $target_program)
                    <li class="flex items-center">
                        <p class="ml-4 text-sm text-gray-600">{{ $target_program->kinerja }} {{ $target_program->satuan }}</p>
                    </li>
                @endforeach
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
                                icon="heroicon-o-arrow-trending-up"
                                color="warning"
                            >
                                Kinerja
                            </x-filament::badge>
                            <p class="text-lg text-gray-600">
                            {{ $kegiatan->target_kegiatan->kinerja }} {{ $kegiatan->target_kegiatan->satuan }}
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
                                            icon="heroicon-o-arrow-trending-up"
                                            color="warning"
                                        >
                                            Kinerja
                                        </x-filament::badge>
                                        {{ $subkegiatan->target_subkegiatan->kinerja }} {{ $subkegiatan->target_subkegiatan->satuan }}
                                        @if(auth()->id() == $subkegiatan->user_id || auth()->id() == 1 || auth()->id() == 2)
                                            {{ ($this->editTargetsubkegiatanAction)(['target_subkegiatan' => $subkegiatan->target_subkegiatan->id]) }}
                                        @endif
                                    </x-slot>
                                    <x-slot name="description">
                                        <b>Kode:</b> {{ $subkegiatan->kode }} <br>
                                        <b>Indikator:</b> {{ $subkegiatan->target_subkegiatan?->indikator }}
                                    </x-slot>
                                    <x-filament::section>
                                        <x-slot name="heading">
                                            Aktivitas
                                        </x-slot>
                                        @if(auth()->id() == $subkegiatan->user_id || auth()->id() == 1 || auth()->id() == 2)
                                        <x-slot name="headerEnd">
                                            {{ ($this->createAction)(['subkegiatan' => $subkegiatan->id]) }}
                                        </x-slot>
                                        @endif
                                    @if($subkegiatan->aktivitas->isNotEmpty())
                                        <div class="mt-1 border-t border-gray-100">
                                            <div class="divide-y divide-gray-100">
                                            @foreach($subkegiatan->aktivitas as $aktivitas)
                                                <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                                    <div class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $loop->iteration }}. {{ $aktivitas->uraian }}</div>
                                                    @if(auth()->id() == $subkegiatan->user_id || auth()->id() == 1 || auth()->id() == 2)
                                                    <div class="mx-auto my-auto sm:col-span-1 sm:mt-0">{{ ($this->editAktivitasAction)(['aktivitas' => $aktivitas->id]) }} {{ ($this->deleteAktivitasAction)(['aktivitas' => $aktivitas->id]) }}</div>
                                                    @endif
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p>Belum ada aktivitas</p>
                                    @endif
                                    </x-filament::section>
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
