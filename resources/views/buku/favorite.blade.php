@extends('master')

@section('title', 'Buku Favorit')
@section('header', 'Buku Favorit')

@section('content')
    @if(Session::has('pesanHapusFavorite'))
        <div class="alert alert-success">{{ Session::get('pesanHapusFavorite') }}</div>
    @endif
    <div class="container mx-auto px-4">
        @if($favorites->isEmpty())
            <p>Anda belum memiliki buku favorit.</p>
        @else
            <div class="overflow-x-auto">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($favorites as $key => $favorite)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $favorite->buku->judul }}</td>
                                <td>{{ $favorite->buku->penulis }}</td>
                                <td>
                                    <form action="{{ route('buku.removeFromFavorite', $favorite->buku->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
