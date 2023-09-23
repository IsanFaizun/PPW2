@extends('master')

@section('title', 'Tambah Buku')

@section('content')
    <h2>Tambah buku</h2>
        <form action="{{ route('buku.store') }}" method="POST">
            @csrf
            <table>
                <tr>
                    <td>Judul</td>
                    <td><input type="text" name="judul"></td>
                </tr>
                <tr>
                    <td>Penulis</td>
                    <td><input type="text" name="penulis"></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td><input type="text" name="harga"></td>
                </tr>
                <tr>
                    <td>Tgl. Terbit</td>
                    <td><input type="text" name="tgl_terbit"></td>
                </tr>
                <tr>
                    <td><button type="submit" class="btn btn-primary">Simpan</button></td>
                    <td><a href="/toko_buku" class="btn btn-secondary">Batal</a></td>
                </tr>
            </table>
        </form>
@endsection        