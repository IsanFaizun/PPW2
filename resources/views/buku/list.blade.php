@extends('master')

@section('title', 'List Buku')
@section('header', 'List Buku')

@section('content')
    <div class="clearfix">
        <form action="{{ route('buku.search') }}" method="get">@csrf
            <input type="text" name="kata" class="form-control mb-3" placeholder="Cari..." style="width: 90%; display: inline; float: left;">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-3" style="width: 110px; float: right;">Cari</button>
        </form>
    </div>
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
                @if($buku->jumlah_user_rating > 0)
                    <p class="text-lg font-medium mb-2">{{ number_format($buku->avg_rating, 2) }} ({{ $buku->jumlah_user_rating }} users)</p>
                @else
                    <p class="text-lg font-medium mb-2">Not Available</p>
                @endif
                <a href="{{ route('buku.detail', $buku->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Lihat detail</a>
            </div>
        </div>
    @endforeach
    <div>{{ $data_buku->links() }}</div>
@endsection
