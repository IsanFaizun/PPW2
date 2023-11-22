@extends('master')

@section('title', 'Index')

@section('content')
<h4>Data Buku</h4>
    @if(Session::has('pesan'))
        <div class="alert alert-success">{{ Session::get('pesan') }}</div>
    @endif
    @if(Session::has('pesanHapus'))
        <div class="alert alert-danger">{{ Session::get('pesan') }}</div>
    @endif
    <form action="{{ route('buku.search') }}" method="get">@csrf
        <input type="text" name="kata" class="form-control" placeholder="Cari..." style="width: 90%; display: inline; float: left;">
        <button type="submit" class="btn btn-primary" style="width: 110px; float: right;">Cari</button>
    </form>
    <br><br><br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Buku</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tgl. Terbit</th>
                @if(Auth::check() && Auth::user()->level == 'admin')
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku as $buku)
                <tr>
                    <td>{{++$no}}</td>
                    <td>
                        @if ( $buku->filepath )
                        <div class="relative h-75 w-75">
                            <img class="h-full w-full object-cover object-center"
                            src="{{ asset($buku->filepath) }}" alt="">
                        </div>
                        @endif
                    </td>
                    <td>{{$buku->judul}}</td>
                    <td>{{$buku->penulis}}</td>
                    <td>{{"Rp ".number_format($buku->harga, 0, ',', ".")}}</td>
                    <td>{{date('d/m/Y', strtotime($buku->tgl_terbit))}}</td>
                    <td>
                        @if(Auth::check() && Auth::user()->level == 'admin')
                        @csrf
                        <a class="btn btn-danger" href="{{ route('buku.destroy', $buku->id) }}" onclick="return confirm('Are you sure?')">Hapus</a>
                        <a class="btn btn-warning" href="{{ route('buku.edit', $buku->id) }}">Edit</a>
                        @endif
                        <a class="btn btn-secondary" href="{{ route('buku.detail-buku', $buku->id) }}">Lihat</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@if(Auth::check() && Auth::user()->level == 'admin')
<p align="right"><a href="{{ route('buku.create')}}" class="btn btn-primary">Tambah Buku</a></p>
@endif
<div>{{ $data_buku->links() }}</div>
<p>{{ "Jumlah buku: ".$jumlah_buku }} buku</p>
<p>{{ "Total harga: Rp".number_format($total_harga, 0, ',', '.') }}</p>
@endsection
