@extends('master')

@section('title', 'Index')
@section('header', 'Cari Buku')

@section('content')
    <style>
        .primary-button{
            background-color: #007bff;
            padding-top: 6.5px;
            padding-bottom: 6.5px;
            border-radius: 5px;
            color: white;
        }
        .primary-button:hover{
            background-color: #0275d8;
        }
    </style>
@if(count($data_buku))
    <div class="alert alert-success">Ditemukan <strong>{{ count($data_buku) }}</strong> data dengan kata: <strong>{{ $cari }}</strong></div>
    <h4>Data Buku</h4>
    @if(Session::has('pesan'))
        <div class="alert alert-success">{{ Session::get('pesan') }}</div>
    @endif
    @if(Session::has('pesanHapus'))
        <div class="alert alert-danger">{{ Session::get('pesan') }}</div>
    @endif
    <form action="{{ route('buku.search') }}" method="get">@csrf
        <input type="text" name="kata" class="form-control" placeholder="Cari..." style="width: 90%; display: inline; float: left;">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded" style="width: 110px; float: right;">Cari</button>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Gambar</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tgl. Terbit</th>
                <th>Rating</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku as $buku)
                <tr>
                    <td>{{++$no}}</td>
                    <td>
                        @if ( $buku->filepath )
                        <div class="relative h-50 w-50">
                            <img class="h-50 w-50 object-cover object-center"
                            src="{{ asset($buku->filepath) }}" alt="">
                        </div>
                        @endif
                    </td>
                    <td>{{$buku->judul}}</td>
                    <td>{{$buku->penulis}}</td>
                    <td>{{"Rp ".number_format($buku->harga, 0, ',', ".")}}</td>
                    <td>{{date('d/m/Y', strtotime($buku->tgl_terbit))}}</td>
                    <td>
                    @if($buku->jumlah_user_rating > 0)
                        <p> {{ number_format($buku->avg_rating, 2) }} ({{ $buku->jumlah_user_rating }} users)</p>
                    @else
                        <p>Not Available</p>
                    @endif
                    </td>
                    @if(Auth::check() && Auth::user()->level == 'admin')
                    <td>
                        <form action="{{ route('buku.destroy', $buku->id) }}" method="post">
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus</button>
                            <a class="btn btn-warning" href="{{ route('buku.edit', $buku->id) }}">Edit</a>
                        </form>
                    </td>
                    @else
                    <td>
                        <a class="btn btn-info" href="">Lihat detail</a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@if(Auth::check() && Auth::user()->level == 'admin')
<p align="right"><a href="{{ route('buku.create')}}" class="btn btn-primary">Tambah Buku</a></p>
@endif
<div>{{ $data_buku->links() }}</div>
<p>{{ "Jumlah buku: ".$jumlah_buku }} buku</p>
@else
    <div class="alert alert-warning"><h4>{{ $cari }} tidak ditmukan</h4> <a href="/toko_buku" class="btn btn-warning">Kembali</a></div>
@endif
@endsection
