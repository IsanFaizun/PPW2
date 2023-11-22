@extends('master')

@section('title', 'Detail Buku')

@section('content')
    <h2>Detail buku</h2>
    <div class="row">
        <div class="col-auto">
            <img src="{{ $buku->filepath }}">
        </div>
        <div class="col">
            <table>
                <tr>
                    <td>Judul</td>
                    <td class="px-2">:</td>
                    <td>{{ $buku->judul }}</td>
                </tr>
                <tr>
                    <td>Penulis</td>
                    <td class="px-2">:</td>
                    <td>{{ $buku->penulis }}"</td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td class="px-2">:</td>
                    <td>{{ $buku->harga }}"</td>
                </tr>
                <tr>
                    <td>Tgl. Terbit</td>
                    <td class="px-2">:</td>
                    <td>{{ $buku->tgl_terbit }}</td>
                </tr>
            </table>
        </div>
    </div>
    <br><br>
    <h4>Gallery</h4>
    <div class="row">
        @foreach($buku->galleries()->get() as $gallery)
        <div class="col-4">
            <a href="{{ asset($gallery->path) }}" data-lightbox="image-1">
                <img src="{{ asset($gallery->path) }}" width="400">
            </a>
        </div>
        @endforeach
    </div>
@endsection