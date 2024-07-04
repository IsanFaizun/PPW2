@extends('master')

@section('title', 'Tambah Buku')
@section('header', 'Tambah Buku')

@section('content')
    <style>
        .primary-button{
            background-color: #007bff;
            padding-top: 6.5px;
            padding-bottom: 6.5px;
            padding-right: 10px;
            padding-left: 10px;
            border-radius: 5px;
            color: white;
        }
        .primary-button:hover{
            background-color: #0275d8;
        }
    </style>
    @if (count($errors) > 0)
        <ul class="alert alert-danger px-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
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
                <td><input type="text" name="tgl_terbit" class="date form-control" placeholder="dd/mm/yyyy"></td>
            </tr>
            <tr>
                <td>Thumbnail</td>
                <td><input type="file" id="thumbnail" name="thumbnail"></td>
            </tr>
            <tr>
                <td><button type="submit" class="primary-button">Simpan</button></td>
                <td><a href="/dashboard" class="btn btn-secondary">Batal</a></td>
            </tr>
        </table>
    </form>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.date').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true
            });
        });
    </script>
@endsection