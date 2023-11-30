@extends('master')

@section('title', 'Favorit')

@section('content')
<h4>Buku Favorit</h4>
    <br><br><br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Buku</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
