<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BukuController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    public function index(){
        $batas = 5;
        $jumlah_buku = Buku::count('id');
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage()-1);
        $total_harga = Buku::sum('harga');

        return view('dashboard', compact('data_buku', 'no', 'jumlah_buku', 'total_harga'));
    }

    public function favourite(){
        $batas = 5;
        $jumlah_buku = Buku::count('id');
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage()-1);

        return view('favourite', compact('data_buku', 'no', 'jumlah_buku',));
    }

    public function create(){
        return view('buku.create');
    }

    public function store(Request $request){
        $this->validate($request,[
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);
        $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
        $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

        Image::make(storage_path().'/app/public/uploads/'.$fileName)->fit(240,320)->save();
        
        Buku::create([
            'judul' => $request -> judul,
            'penulis' => $request -> penulis,
            'harga' => $request -> harga,
            'tgl_terbit' => $request -> tgl_terbit,
            'filename' => $fileName,
            'filepath' => '/storage/' . $filePath

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

    public function update(Request $request, string $id){
        $buku = Buku::find($id);

        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        if ($request->file('thumbnail')) {
            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
            Image::make(storage_path().'/app/public/uploads/'.$fileName)->fit(240,320)->save();
        };

        $data = [
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tgl_terbit' => $request->tgl_terbit,
            'harga' => $request->harga,
        ];

        if ($request->file('thumbnail')) {
            $data['filename'] = $fileName;
            $data['filepath'] = '/storage/'.$filePath;
        }

        $buku->update($data);
        
        if ($request->file('gallery')) {
            foreach($request->file('gallery') as $key => $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                $gallery = Gallery::create([
                    'nama_galeri' => $fileName,
                    'path' => '/storage/'. $filePath,
                    'foto' => $fileName,
                    'buku_id' => $id
                ]);
            }
        }

        return redirect('/toko_buku')->with('pesan','Data Buku Berhasil Disimpan');
    }

    public function search(Request $request){
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%".$cari."%")->orwhere('penulis', 'like', "%".$cari."%")->paginate($batas);
        $jumlah_buku = $data_buku->count();
        $no = $batas * ($data_buku->currentPage()-1);

        return view('buku.search', compact('data_buku', 'no', 'jumlah_buku', 'cari'));
    }

    public function deleteGallery($id) {
        $gallery = Gallery::findOrFail($id);

        $gallery->delete();

        return redirect()->back();
    }

    public function detailBuku($id) {
        $buku = Buku::find($id);
        return view('buku.detail-buku', compact('buku'));
    }

    public function rate(Request $request, Buku $buku) {
        $user = $request->user();

        $rate = $this->rateBook ($user, $buku, $request->value);
        $this->setBookRate ($buku);

        return [
            'id' => $buku->id,
            'value' => $buku->rate,
            'count' => $buku->users->count(),
            'rate' => $rate
        ];
    }

    public function rateImage($user, $buku, $value) {
        $rate = $buku->users()->where('users.id', $user->id)->pluck('rating')->first();

        if($rate) {
            if($rate !== $value) {
                $buku->users ()->updateExistingPivot ($user->id, ['rating' => $value]);
            }
        } else {
            $buku->users ()->attach ($user->id, ['rating' => $value]);
        }

        return $rate;
    }
}
