@extends('master')

@section('title', 'Buku Favorit')
@section('header', 'Buku Favorit')

@section('content')
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
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
