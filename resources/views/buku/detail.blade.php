@extends('master')

@section('title', 'Detail Buku')
@section('header', 'Detail Buku')


@section('content')
    <div class="flex">
        <div class="flex-shrink-0">
            <img src="{{ $buku->filepath }}" alt="Gambar Buku" class="h-80 w-80 object-contain">
        </div>
        <div class="ml-4">
            <table class="text-sm">
                <tr>
                    <td class="font-semibold">Judul</td>
                    <td class="px-2">:</td>
                    <td>{{ $buku->judul }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Penulis</td>
                    <td class="px-2">:</td>
                    <td>{{ $buku->penulis }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Harga</td>
                    <td class="px-2">:</td>
                    <td>{{ $buku->harga }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Tgl. Terbit</td>
                    <td class="px-2">:</td>
                    <td>{{ $buku->tgl_terbit }}</td>
                </tr>
            </table>
        </div>
    </div>
    <br><br>
    <div class="row">
    @foreach($buku->galleries()->get() as $gallery)
        <div class="w-1/4 p-2">
            <img src="{{ asset($gallery->path) }}" class="cursor-pointer" onclick="openLightbox('{{ asset($gallery->path) }}')" />
        </div>
    @endforeach
    </div>

    <!-- Lightbox container -->
    <div id="lightbox" class="hidden fixed z-50 inset-0 p-10 bg-black/75 flex items-center justify-center">
        <a href="#" onclick="closeLightbox()" class="bg-white px-3 py-1 text-black absolute right-0 top-0">X</a>
        <img id="lightbox-image" src="" width="400">
    </div>

    <!-- JavaScript -->
    <script>
        function openLightbox(imageSrc) {
            document.getElementById('lightbox-image').src = imageSrc;
            document.getElementById('lightbox').classList.remove('hidden');
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
        }
    </script>
@endsection