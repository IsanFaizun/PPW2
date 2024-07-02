@extends('master')

@section('title', 'Tambah Buku')

@section('content')
    <h2>Tambah buku</h2>
        @if (count($errors) > 0)
            <ul class="alert alert-danger px-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form action="{{ route('buku.store') }}" method="POST", enctype="multipart/form-data">
            @csrf
            <table>
                <tr>
                    <td>Judul</td>
                    <td><input type="text" name="judul" class="form-control"></td>
                </tr>
                <tr>
                    <td>Penulis</td>
                    <td><input type="text" name="penulis" class="form-control"></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td><input type="text" name="harga" class="form-control"></td>
                </tr>
                <tr>
                    <td>Tgl. Terbit</td>
                    <td><input type="text" name="tgl_terbit" class="date form-control" placeholder="yyyy/mm/dd"></td>
                </tr>
                <tr>
                    <td>Thumbnail</td>
                    <td><input type="file" name="thumbnail" class="form-control"></td>
                </tr>
                <tr>
                    <td><button type="submit" class="btn btn-primary">Simpan</button></td>
                    <td><a href="/dashboard" class="btn btn-secondary">Batal</a></td>
                </tr>
            </table>
        </form>
@endsection        