@extends('master')

@section('title', 'Detail Buku')
@section('header', 'Detail Buku')

@section('content')
    @if(Session::has('pesanRating'))
        <div class="alert alert-success">{{ Session::get('pesanRating') }}</div>
    @endif
    @if(Session::has('pesanFavorite'))
        <div class="alert alert-success">{{ Session::get('pesanFavorite') }}</div>
    @endif
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
            <form action="{{ route('buku.addToFavorite', $buku->id) }}" method="post">
                @csrf
                <button class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded mt-2" type="submit">Tambah ke Favorit</button>
            </form>
        </div>
    </div>
    <br><br>
    <div class="px-12">
        <p class="text-2xl font-semibold mb-2">Galeri</p>
        @foreach($buku->galleries()->get() as $gallery)
            <div class="w-1/4 p-2">
                <img src="{{ asset($gallery->path) }}" class="cursor-pointer" onclick="openLightbox('{{ asset($gallery->path) }}')" />
            </div>
        @endforeach
    </div>

    <!-- Lightbox container -->
    <div id="lightbox" class="hidden fixed z-50 inset-0 p-10 bg-black/75 flex items-center justify-center">
        <a href="#" onclick="closeLightbox()" class="bg-white px-3 py-1 text-black absolute right-0 top-0">X</a>
        <img id="lightbox-image" src="" width="950">
    </div>

    <br><br>
    <div class="px-12">
        <p class="text-2xl font-semibold mb-2">Beri Rating</p>
        <form action="{{ route('buku.rate', $buku->id) }}" method="post">
            @csrf
            <select name="rating" required>
                @if ($buku->rating()->where('user_id', auth()->id())->exists())
                    @php
                        $currentRating = $buku->rating()->where('user_id', auth()->id())->first()->rate;
                    @endphp
                    <option value="1" {{ $currentRating == 1 ? 'selected' : '' }}>1 - Sangat Buruk</option>
                    <option value="2" {{ $currentRating == 2 ? 'selected' : '' }}>2 - Buruk</option>
                    <option value="3" {{ $currentRating == 3 ? 'selected' : '' }}>3 - Cukup</option>
                    <option value="4" {{ $currentRating == 4 ? 'selected' : '' }}>4 - Baik</option>
                    <option value="5" {{ $currentRating == 5 ? 'selected' : '' }}>5 - Sangat Baik</option>
                @else
                    <option value="" disabled selected>Pilih Rating</option>
                    <option value="1">1 - Sangat Buruk</option>
                    <option value="2">2 - Buruk</option>
                    <option value="3">3 - Cukup</option>
                    <option value="4">4 - Baik</option>
                    <option value="5">5 - Sangat Baik</option>
                @endif
            </select>
            <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded" type="submit">Submit</button>
        </form>
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