@extends('master')

@section('title', 'Edit Buku')

@section('content')
    <h2>Edit buku</h2>
    <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td>Judul</td>
                <td><input type="text" name="judul" value="{{ $buku->judul }}" class="form-control"></td>
            </tr>
            <tr>
                <td>Penulis</td>
                <td><input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control"></td>
            </tr>
            <tr>
                <td>Harga</td>
                <td><input type="text" name="harga" value="{{ $buku->harga }}" class="form-control"></td>
            </tr>
            <tr>
                <td>Tgl. Terbit</td>
                <td><input type="text" name="tgl_terbit" value="{{ $buku->tgl_terbit }}" class="date form-control" placeholder="yyyy/mm/dd"></td>
            </tr>
            <tr>
                <td>Thumbnail Saat Ini</td>
                <td>
                    @if ($buku->filepath)
                        <img src="{{ asset($buku->filepath) }}" alt="Thumbnail" width="200">
                    @else
                        Tidak ada thumbnail
                    @endif
                </td>
            </tr>
            <tr>
                <td>Ubah Thumbnail</td>
                <td><input type="file" name="thumbnail" class="form-control"></td>
            </tr>
            <tr>
                <td>Gallery</td>
                <td>
                    <div id="fileinput_wrapper"></div>
                    <div class="d-grid">
                        <a class="btn btn-outline-secondary my-2" href="javascript:void(0);" id="tambah" onclick="addFileInput()">Tambah</a>
                    </div>
                    <script type="text/javascript">
                        function addFileInput () {
                            var div = document.getElementById('fileinput_wrapper');
                            div.innerHTML += '<div class="input-group my-1"><input type="file" class="form-control" name="gallery[]" id="gallery"></div>';
                        };
                    </script>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <div class="container-fluid">
                        <div class="row align-items-start gap-3">
                            @foreach($buku->galleries()->get() as $gallery)
                                <div class="col">
                                    <img src="{{ asset($gallery->path) }}" alt="" width="400"/>
                                </div>
                                <div>
                                    <a href="{{ route('buku.deleteGallery', $gallery->id) }}" class="btn btn-dark btn-sm">Delete Gallery</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="/dashboard" class="btn btn-secondary">Batal</a>
                    </div>
                </td>
            </tr>
        </table>
    </form>
@endsection
