@extends('master')

@section('title', 'Buku Populer')
@section('header', 'Buku Populer')

@section('content')
    <div class="container mx-auto px-4">
        <div class="overflow-x-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Rating</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_buku as $buku)
                        @if($buku->rating->count() > 0)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ number_format($buku->rating->avg('rate'), 2) }}</td>
                            <td>
                                <a href="{{ route('buku.detail', $buku->id) }}" class="btn btn-primary">Lihat Detail</a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
