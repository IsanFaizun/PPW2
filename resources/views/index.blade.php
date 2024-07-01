@extends('master')

@section('title', 'Index')

@section('content')
<h4>Data Buku</h4>
    @if(Session::has('pesan'))
        <div class="alert alert-success">{{ Session::get('pesan') }}</div>
    @endif
    @if(Session::has('pesanHapus'))
        <div class="alert alert-danger">{{ Session::get('pesanHapus') }}</div>
    @endif
    <form action="{{ route('buku.search') }}" method="get">@csrf
        <input type="text" name="kata" class="form-control" placeholder="Cari..." style="width: 90%; display: inline; float: left;">
        <button type="submit" class="btn btn-primary" style="width: 110px; float: right;">Cari</button>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tgl. Terbit</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku as $buku)
                <tr>
                    <td>{{++$no}}</td>
                    <td>{{$buku->judul}}</td>
                    <td>{{$buku->penulis}}</td>
                    <td>{{"Rp ".number_format($buku->harga, 0, ',', ".")}}</td>
                    <td>{{date('d/m/Y', strtotime($buku->tgl_terbit))}}</td>
                    <td>
                        <form action="{{ route('buku.destroy', $buku->id) }}" method="post">
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus</button>
                            <a class="btn btn-secondary" href="{{ route('buku.edit', $buku->id) }}">Edit</a>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<p align="right"><a href="{{ route('buku.create')}}" class="btn btn-primary">Tambah Buku</a></p>
<div>{{ $data_buku->links() }}</div>
<p>{{ "Jumlah buku: ".$jumlah_buku }} buku</p>
<p>{{ "Total harga: Rp".number_format($total_harga, 0, ',', '.') }}</p>
@endsection
