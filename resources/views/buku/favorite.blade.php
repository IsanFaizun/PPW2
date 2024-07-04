@extends('master')

@section('title', 'Buku Favorit')
@section('header', 'Buku Favorit')

@section('content')
    @if(Session::has('pesanHapusFavorite'))
        <div class="alert alert-success">{{ Session::get('pesanHapusFavorite') }}</div>
    @endif
    <div class="px-12">
        @if($favorites->isEmpty())
            <p>Anda belum memiliki buku favorit.</p>
        @else
            <ul>
                @foreach($favorites as $favorite)
                    <li>
                        <a href="{{ route('buku.detail', $favorite->buku->id) }}">
                            {{ $favorite->buku->judul }}
                        </a>
                        <form action="{{ route('buku.removeFromFavorite', $favorite->buku->id) }}" method="post" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded" type="submit">Hapus</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
