<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    
    public function index(){
        $batas = 10;
        $jumlah_buku = Buku::count('id');
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage()-1);
        $total_harga = Buku::sum('harga');

        return view('dashboard', compact('data_buku', 'no', 'jumlah_buku', 'total_harga'));
    }

    public function create(){
        return view('buku.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date'
        ]);
        Buku::create([
            'judul' => $request -> judul,
            'penulis' => $request -> penulis,
            'harga' => $request -> harga,
            'tgl_terbit' => $request -> tgl_terbit
        ]);
        return redirect('/toko_buku')->with('pesan','Data Buku Berhasil Disimpan');
    }

    public function destroy($id){
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/toko_buku')->with('pesanHapus','Data Buku Berhasil Dihapus');
    }

    public function edit($id){
        $buku = Buku::find($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id){
        $buku = Buku::find($id);

        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
        $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

        $buku->update([
            'judul' => $request -> judul,
            'penulis' => $request -> penulis,
            'harga' => $request -> harga,
            'tgl_terbit' => $request -> tgl_terbit,
            'filename' => $fileName,
            'filepath' => '/storage' . $filePath
        ]);
        return redirect('/toko_buku')->with('pesan','Data Buku Berhasil Diubah');
    }

    public function search(Request $request){
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%".$cari."%")->orwhere('penulis', 'like', "%".$cari."%")->paginate($batas);
        $jumlah_buku = $data_buku->count();
        $no = $batas * ($data_buku->currentPage()-1);

        return view('buku.search', compact('data_buku', 'no', 'jumlah_buku', 'cari'));
    }
}
