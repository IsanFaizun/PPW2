@extends('master')

@section('title', 'List Buku')
@section('header', 'List Buku')

@section('content')
    @foreach ($data_buku as $buku)
        <div class="flex items-center space-x-1 mb-4">
            @if ($buku->filepath)
            <div class="relative h-50 w-50">
                <img class="h-25 w-25 object-cover object-center"
                src="{{ asset($buku->filepath) }}" alt="">
            </div>
            @endif
            <div>
                <p class="text-lg font-medium mb-2">{{$buku->judul}}</p>
                <a href="{{ route('buku.detail', $buku->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Lihat detail</a>
            </div>
        </div>
    @endforeach
    <div>{{ $data_buku->links() }}</div>
@endsection
