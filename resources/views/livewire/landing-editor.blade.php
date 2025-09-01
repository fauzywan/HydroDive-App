<div class="p-6">
    {{-- Notifikasi --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 1500)" x-show="show" x-transition>
            <flux:callout icon="sparkles" color="green">
                <flux:callout.heading>Berhasil</flux:callout.heading>
                <flux:callout.text>{{ session('message') }}</flux:callout.text>
            </flux:callout>
        </div>
    @endif

    {{-- Navbar --}}
    <flux:navbar.item icon="arrow-left" href="/app-settings" wire:navigate>Kembali</flux:navbar.item>
    <div class="flex flex-row justify-center mt-5 mb-10">
        <flux:navbar>
            <flux:navbar.item href="#" wire:click="show(1)">Jumbotron</flux:navbar.item>
            <flux:navbar.item href="#" wire:click="show(2)">Tentang Kami</flux:navbar.item>
            <flux:navbar.item href="#" wire:click="show(3)">Visi Misi</flux:navbar.item>
            <flux:navbar.item href="#" wire:click="show(4)">Lokasi</flux:navbar.item>
            <flux:navbar.item href="#" wire:click="show(5)">Footer</flux:navbar.item>
        </flux:navbar>
        <div></div>
    </div>

    {{-- Form Hero --}}
    @if ($formShow == 4)
    <form wire:submit="save(4)" class="max-w-2xl mx-auto space-y-4">
   <div class="grid grid-cols-2">
                <flux:field>
                    <flux:label>Judul</flux:label>
                    <flux:input wire:model="lokasiTitle" />
                </flux:field>
                <flux:field>
                    <flux:label>Judul</flux:label>
                    <flux:input wire:model="lokasiTitle2" />
                </flux:field>
            </div>

            <flux:field>
            <flux:label>Deskripsi</flux:label>
            <flux:textarea wire:model="lokasiDesc" />
        </flux:field>
            <flux:field>
            <flux:label>Deskripsi</flux:label>
            <flux:textarea wire:model="lokasiDesc2" />
        </flux:field>

        <flux:field>
            <flux:label>Embed Google Maps (opsional)</flux:label>
            <flux:input wire:model="data.lokasi.link_peta" />
            <small class="text-sm text-gray-500">Masukkan URL iframe dari Google Maps.</small>
        </flux:field>
        <flux:field>
            <flux:label>Lihat Di Google Map</flux:label>
            <flux:input wire:model="lokasiLihatMap" />
            <small class="text-sm text-gray-500">Masukkan URL pada bagian Link to share di Google Maps</small>
        </flux:field>

        <flux:button type="submit">Simpan</flux:button>
    </form>
    @elseif ($formShow == 1)
        <form wire:submit="save(1)" class="max-w-2xl mx-auto space-y-4">
            <div class="grid grid-cols-2">
                <flux:field>
                    <flux:label>Judul</flux:label>
                    <flux:input wire:model="heroTitle" />
                </flux:field>
                <flux:field>
                    <flux:label>Judul</flux:label>
                    <flux:input wire:model="heroAppName" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>Deskripsi</flux:label>
                <flux:textarea wire:model="heroDesc" />
            </flux:field>

            <flux:field>
        <flux:label>Jenis Gambar</flux:label>
        <flux:select wire:model.live="imageInputType1" wire:key="{{ $imageInputType1 }}">
            <flux:select.option value="1">Gunakan URL</flux:select.option>
            <flux:select.option value="2">Upload Gambar</flux:select.option>
        </flux:select>
    </flux:field>
    <flux:field>
        <flux:label>Gambar</flux:label>
        <flux:input type="text" style="display:{{ $uploadTypeJumbotron1==2?'none':'block' }}" wire:model="heroImg"  />
        @if ($uploadTypeJumbotron1 == 2)
        <flux:input type="file" wire:model="uploadedImage1" />

            @endif
        </flux:field>
            <flux:button type="submit"   wire:loading.attr="disabled" wire:target="uploadedImage1">Simpan</flux:button>
        </form>

    {{-- Form Tentang Kami --}}
    @elseif ($formShow == 2)
        <form wire:submit="save(2)" class="max-w-2xl mx-auto space-y-4">
            <div class="grid grid-cols-2 gap-2">
                <flux:field>
                    <flux:label>Judul Tentang Kami</flux:label>
                    <flux:input wire:model="tentangTitle" />
                </flux:field>
                <flux:field>
                    <flux:label style="opacity: 0">Hero</flux:label>
                    <flux:input wire:model="tentangAppName" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>Deskripsi</flux:label>
                <flux:textarea wire:model="tentangDesc" />
            </flux:field>

            <flux:button type="submit">Simpan</flux:button>
        </form>

        {{-- Form Visi Misi --}}
        @elseif ($formShow == 3)
        <form wire:submit="save(3)" class="max-w-2xl mx-auto space-y-4">
            <flux:field>
                <flux:label>Judul</flux:label>
                <flux:input wire:model="visiMisiTitle" />
            </flux:field>

{{-- YOHI --}}
            <flux:field>
        <flux:label>Jenis Gambar</flux:label>
        <flux:select wire:model.live="imageInputType" wire:key="{{ $imageInputType }}">
            <flux:select.option value="4">Gunakan URL</flux:select.option>
            <flux:select.option value="3">Upload Gambar</flux:select.option>
        </flux:select>
    </flux:field>
    <flux:field>
        <flux:label>Gambar</flux:label>
        <flux:input type="text" style="display:{{ $uploadTypeJumbotron==3?'none':'block' }}" wire:model="visiMisiImg"  />
        @if ($uploadTypeJumbotron == 3)
        <flux:input type="file" wire:model="uploadedImage" />

        @endif
    </flux:field>
{{-- YOGI --}}
            <flux:field>
                <flux:label>Visi</flux:label>
                <flux:textarea wire:model="visiMisiVisi" />
            </flux:field>

             @foreach ($data['visi_misi']['misi']['items'] as $index => $item)
        <div class="flex items-center gap-2" wire:key="misi-{{ $index }}">
            <flux:input wire:model="data.visi_misi.misi.items.{{ $index }}" class="flex-1" />
            <flux:button type="button" variant="danger" wire:click="removeMisi({{ $index }})">Hapus</flux:button>
        </div>
    @endforeach
    <div class="flex flex-end justify-end">
        <flux:button type="button" icon="plus" wire:click="addMisi">Tambah Misi</flux:button>
    </div>
    <div class="grid grid-cols-3 gap-2">
        @foreach ($data['moto']['cards'] as $index=> $item)
        <flux:field>
            <flux:label style="opacity: 0">Hero</flux:label>
            <flux:input wire:model="data.moto.cards.{{ $index }}.title" />
              <flux:textarea wire:model="data.moto.cards.{{ $index }}.description" />
        </flux:field>
        @endforeach
    </div>
    <flux:button type="submit">Simpan</flux:button>
</form>
@elseif ($formShow == 5)
<form wire:submit="save(5)" class="max-w-2xl mx-auto space-y-4">
    <flux:field>
        <flux:label>Deskripsi</flux:label>
        <flux:textarea wire:model="footerApp" />
    </flux:field>

    <flux:field>
        <flux:label>Judul Kontak</flux:label>
        <flux:input wire:model="footerKontakJudul" />
    </flux:field>

    {{-- Item Kontak --}}
    <div class="space-y-2">
        <flux:label class="font-semibold">Item Kontak</flux:label>
        @foreach ($footerKontakItems as $index => $item)
        <div class="flex gap-2 items-center" wire:key="kontak-{{ $index }}">
            <flux:input wire:model="footerKontakItems.{{ $index }}.text" placeholder="Label (misal: Email)" />
            <flux:input wire:model="footerKontakItems.{{ $index }}.deskripsi" placeholder="Deskripsi (misal: info@email.com)" />
            <flux:button type="button" variant="danger" wire:click="removeKontak({{ $index }})">Hapus</flux:button>
        </div>
        @endforeach
        <flux:button type="button" icon="plus" wire:click="addKontak">Tambah Kontak</flux:button>
    </div>

    {{-- Media Sosial --}}
    <div class="space-y-2">
        <flux:label class="font-semibold">Media Sosial</flux:label>
        @foreach ($footerSosial as $index => $sosial)
        <div class="flex gap-2 items-center" wire:key="sosial-{{ $index }}">
            <flux:input wire:model="footerSosial.{{ $index }}.platform" placeholder="Platform (Instagram)" />
            <flux:input wire:model="footerSosial.{{ $index }}.icon" placeholder="Icon (fa-brands fa-instagram)" />
            <flux:input wire:model="footerSosial.{{ $index }}.url" placeholder="https://instagram.com/..." />
            <flux:button type="button" variant="danger" wire:click="removeSosial({{ $index }})">Hapus</flux:button>
        </div>
        @endforeach
        <flux:button type="button" icon="plus" wire:click="addSosial">Tambah Sosial Media</flux:button>
    </div>

    <flux:button type="submit">Simpan</flux:button>
</form>
@endif


</div>
