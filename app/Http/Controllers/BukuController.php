<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Galeri;
use App\Models\Rating;
use App\Models\Favorite;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    
    public function dashboard(){
        $batas = 10;
        $jumlah_buku = Buku::count('id');
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage() - 1);

        $data_buku->transform(function ($buku) {
            if ($buku->rating === null || $buku->rating->isEmpty()) {
                $buku->total_rating = 0;
                $buku->jumlah_user_rating = 0;
                $buku->avg_rating = 'Not Available';
            } else {
                $total_rating = $buku->rating->sum('rate');
                $jumlah_user_rating = $buku->rating->count();
                $avg_rating = $jumlah_user_rating > 0 ? $total_rating / $jumlah_user_rating : 'Not Available';
                
                $buku->total_rating = $total_rating;
                $buku->jumlah_user_rating = $jumlah_user_rating;
                $buku->avg_rating = $avg_rating;
            }
    
            return $buku;
        });
    

        $total_harga = Buku::sum('harga');

        return view('dashboard', compact('data_buku', 'no', 'jumlah_buku', 'total_harga'));
    }

    public function list(){
        $batas = 10;
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $batas = 10;
        $no = $batas * ($data_buku->currentPage()-1);
        $data_buku->transform(function ($buku) {
            if ($buku->rating === null || $buku->rating->isEmpty()) {
                $buku->total_rating = 0;
                $buku->jumlah_user_rating = 0;
                $buku->avg_rating = 'Not Available';
            } else {
                $total_rating = $buku->rating->sum('rate');
                $jumlah_user_rating = $buku->rating->count();
                $avg_rating = $jumlah_user_rating > 0 ? $total_rating / $jumlah_user_rating : 'Not Available';
                
                $buku->total_rating = $total_rating;
                $buku->jumlah_user_rating = $jumlah_user_rating;
                $buku->avg_rating = $avg_rating;
            }
    
            return $buku;
        });

        return view('buku.list', compact('data_buku', 'no'));
    }

    public function detail($id){
        $buku = Buku::find($id);
        return view('buku.detail', compact('buku'));
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
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);
    
        // Periksa apakah ada file yang diunggah
        if ($request->hasFile('thumbnail')) {
            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
            
            $data = [
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'harga' => $request->harga,
                'tgl_terbit' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tgl_terbit)->format('Y-m-d'),
                'filename' => $fileName,
                'filepath' => '/storage/' . $filePath
            ];
        } else {
            $data = [
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'harga' => $request->harga,
                'tgl_terbit' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tgl_terbit)->format('Y-m-d')
            ];
        }
    
        Buku::create($data);
    
        return redirect('/dashboard')->with('pesan', 'Data Buku Berhasil Disimpan');
    }
        

    public function destroy($id){
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/dashboard')->with('pesanHapus','Data Buku Berhasil Dihapus');
    }

    public function edit($id){
        $buku = Buku::find($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id) {
        $buku = Buku::find($id);
    
        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date_format:d/m/Y',
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);
    
        $tgl_terbit = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tgl_terbit)->format('Y-m-d');
    
        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tgl_terbit' => $tgl_terbit,
            'harga' => $request->harga,
        ]);
    
        if ($request->hasFile('thumbnail')) {
            $fileName = time() . '_' . $request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
            $buku->update([
                'filename' => $fileName,
                'filepath' => '/storage/' . $filePath
            ]);
        }

        if ($request->file('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                Galeri::create([
                    'nama_galeri' => $fileName,
                    'path' => '/storage/' . $filePath,
                    'foto' => $fileName,
                    'buku_id' => $id
                ]);
            }
        }
    
        return redirect('/dashboard')->with('pesan','Data Buku Berhasil Diupdate');
    }
    
    public function search(Request $request){
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%".$cari."%")->orwhere('penulis', 'like', "%".$cari."%")->paginate($batas);
        $jumlah_buku = $data_buku->count();
        $no = $batas * ($data_buku->currentPage()-1);
        $data_buku->transform(function ($buku) {
            if ($buku->rating === null || $buku->rating->isEmpty()) {
                $buku->total_rating = 0;
                $buku->jumlah_user_rating = 0;
                $buku->avg_rating = 'Not Available';
            } else {
                $total_rating = $buku->rating->sum('rate');
                $jumlah_user_rating = $buku->rating->count();
                $avg_rating = $jumlah_user_rating > 0 ? $total_rating / $jumlah_user_rating : 'Not Available';
                
                $buku->total_rating = $total_rating;
                $buku->jumlah_user_rating = $jumlah_user_rating;
                $buku->avg_rating = $avg_rating;
            }
    
            return $buku;
        });

        return view('buku.search', compact('data_buku', 'no', 'jumlah_buku', 'cari'));
    }

    public function deleteGallery($id) {
        $gallery = Galeri::findOrFail($id);

        $gallery->delete();

        return redirect()->back();
    }

    public function rate(Request $request, $id) {
        $buku = Buku::findOrFail($id);
        $user_id = auth()->id();
    
        // Cek apakah user sudah memberikan rating untuk buku ini sebelumnya
        $existingRating = Rating::where('user_id', $user_id)
                                ->where('buku_id', $id)
                                ->first();
    
        if ($existingRating) {
            // Jika sudah ada rating sebelumnya, update rating yang sudah ada
            $existingRating->update([
                'rate' => $request->rating,
            ]);
        } else {
            // Jika belum ada rating sebelumnya, buat rating baru
            $buku->rating()->create([
                'user_id' => $user_id,
                'rate' => $request->rating,
            ]);
        }
        return back()->with('pesanRating', 'Rating berhasil ditambahkan');
    }
    

    public function addToFavorite($id) {
        $user_id = auth()->id();

        // Check if the buku is already in the user's favorites
        $existingFavorite = Favorite::where('user_id', $user_id)
                                    ->where('buku_id', $id)
                                    ->first();

        if (!$existingFavorite) {
            // Add to favorites if not already favorited
            Favorite::create([
                'user_id' => $user_id,
                'buku_id' => $id,
            ]);
        }
        return back()->with('pesanFavorite', 'Buku berhasil ditambahkan ke favorit');
    }

    public function removeFromFavorite($id) {
        $user_id = auth()->id();
        $favorite = Favorite::where('user_id', $user_id)
                            ->where('buku_id', $id)
                            ->first();

        if ($favorite) {
            $favorite->delete();
        }

        return back()->with('pesanHapusFavorite', 'Buku berhasil dihapus dari favorit');
    }

    public function favorite() {
        $user_id = auth()->id();
        $favorites = Favorite::where('user_id', $user_id)->with('buku')->get();

        return view('buku.favorite', compact('favorites'));
    }

    public function populer() {
        $data_buku = Buku::with('rating')
                    ->get()
                    ->sortByDesc(function($buku) {
                        return $buku->rating->avg('rate');
                    })
                    ->take(10);
    
        return view('buku.populer', compact('data_buku'));
    }
}
