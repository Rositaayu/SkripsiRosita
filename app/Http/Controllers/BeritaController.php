<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\TagBerita;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Berita::with('kategori', 'user.wartawan', 'tag_berita')->latest()->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }

        return view('pages.berita.index');
    }

    public function create()
    {
        $kategori = KategoriBerita::all();
        $tag = Tag::all();

        return view('pages.berita.create', compact('kategori', 'tag'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori_berita' => ['required', 'exists:kategori_berita,id_kategori_berita'],
            'judul_berita' => ['required', 'string', 'max:255'],
            'foto_berita' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'caption_foto' => ['required', 'string'],
            'artikel_berita' => ['required', 'string'],
            'id_tag' => ['required', 'array'],
            'id_tag.*' => ['exists:tag,id_tag'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('foto_berita')) {
            $file = $request->file('foto_berita');
            $filename = 'foto_' . str_replace(" ", "_", strtolower($request->judul_berita)) . '_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/foto_berita', $file, $filename);
        }

        $berita = Berita::create([
            'id_kategori_berita' => $request->id_kategori_berita,
            'id_user' => auth()->user()->id_user,
            'judul_berita' => $request->judul_berita,
            'foto_berita' => Storage::url('public/foto_berita/' . $filename),
            'caption_foto' => $request->caption_foto,
            'artikel_berita' => $request->artikel_berita,
        ]);

        $tag = [];
        foreach ($request->id_tag as $value) {
            $tag[] = [
                'id_berita' => $berita->id_berita,
                'id_tag' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        TagBerita::insert($tag);

        return redirect()->route('berita')->with('success', 'Berita created successfully.');
    }
}
