<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\Komentar;
use App\Models\TagBerita;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Berita::with('kategori', 'user.wartawan.editor.user', 'tag_berita', 'komentar')->latest()->get();

            if (auth()->user()->role == 'wartawan') {
                $data = Berita::with('kategori', 'user.wartawan.editor.user', 'tag_berita', 'komentar')->where('id_user', auth()->user()->id_user)->latest()->get();
            } else if (auth()->user()->role == 'editor') {
                $data = Berita::with('kategori', 'user.wartawan.editor.user', 'tag_berita', 'komentar')->whereHas('user', function ($query) {
                    $query->whereHas('wartawan', function ($query) {
                        $query->where('id_editor', auth()->user()->editor->id_editor);
                    });
                })->latest()->get();
            }

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }

        return view('pages.berita.index');
    }

    public function show($id)
    {
        $berita = Berita::with('kategori', 'user.wartawan.editor', 'tag_berita.tag')->findOrFail($id);

        return view('pages.berita.show', compact('berita'));
    }

    public function create()
    {
        $kategori = KategoriBerita::all();
        $tag = Tag::all();

        return view('pages.berita.create', compact('kategori', 'tag'));
    }

    public function store(Request $request)
    {
        $rules = [
            'id_kategori_berita' => ['required', 'exists:kategori_berita,id_kategori_berita'],
            'judul_berita' => ['required', 'string', 'max:255'],
            'foto_berita' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'caption_foto' => ['required', 'string'],
            'artikel_berita' => ['required', 'string'],
            'id_tag' => ['required', 'array'],
            'id_tag.*' => ['exists:tag,id_tag'],
        ];

        if (auth()->user()->role == 'editor' || auth()->user()->role == 'super_editor') {
            $rules['status_berita'] = ['required', 'in:0,1,2,3'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('foto_berita')) {
            $file = $request->file('foto_berita');
            $filename = 'foto_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/foto_berita', $file, $filename);
        }

        $berita = Berita::create([
            'id_kategori_berita' => $request->id_kategori_berita,
            'id_user' => auth()->user()->id_user,
            'judul_berita' => $request->judul_berita,
            'foto_berita' => Storage::url('public/foto_berita/' . $filename),
            'caption_foto' => $request->caption_foto,
            'artikel_berita' => $request->artikel_berita,
            'status_berita' => auth()->user()->role == 'wartawan' ? 0 : $request->status_berita,
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

    public function edit($id)
    {
        $berita = Berita::with('tag_berita')->findOrFail($id);
        $kategori = KategoriBerita::all();
        $tag = Tag::all();
        $tagBerita = TagBerita::where('id_berita', $id)->get();
        $tagBerita = $tagBerita->map(function ($item) {
            return $item->id_tag;
        })->toArray();

        return view('pages.berita.edit', compact('berita', 'kategori', 'tag', 'tagBerita'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'id_kategori_berita' => ['required', 'exists:kategori_berita,id_kategori_berita'],
            'judul_berita' => ['required', 'string', 'max:255'],
            'foto_berita' => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'caption_foto' => ['required', 'string'],
            'artikel_berita' => ['required', 'string'],
            'id_tag' => ['required', 'array'],
            'id_tag.*' => ['exists:tag,id_tag'],
        ];

        if (auth()->user()->role == 'editor' || auth()->user()->role == 'super_editor') {
            $rules['status_berita'] = ['required', 'in:0,1,2,3'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $berita = Berita::findOrFail($id);

        if ($request->hasFile('foto_berita')) {
            $file = $request->file('foto_berita');
            $filename = 'foto_' . str_replace(" ", "_", strtolower($request->judul_berita)) . '_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/foto_berita', $file, $filename);
            Storage::delete('public/foto_berita/' . basename($berita->foto_berita));
        }

        $berita->update([
            'id_kategori_berita' => $request->id_kategori_berita,
            'judul_berita' => $request->judul_berita,
            'foto_berita' => $request->hasFile('foto_berita') ? Storage::url('public/foto_berita/' . $filename) : $berita->foto_berita,
            'caption_foto' => $request->caption_foto,
            'artikel_berita' => $request->artikel_berita,
            'status_berita' => auth()->user()->role == 'wartawan' ? $berita->status_berita : $request->status_berita,
        ]);

        TagBerita::where('id_berita', $id)->delete();

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

        return redirect()->route('berita')->with('success', 'Berita updated successfully.');
    }

    public function comment($id)
    {
        $berita = Berita::with('tag_berita', 'komentar')->findOrFail($id);
        $kategori = KategoriBerita::all();
        $tag = Tag::all();
        $tagBerita = TagBerita::where('id_berita', $id)->get();
        $tagBerita = $tagBerita->map(function ($item) {
            return $item->id_tag;
        })->toArray();
        $komentar = Komentar::with('user')->where('id_berita', $id)->get();

        return view('pages.berita.comment', compact('berita', 'kategori', 'tag', 'tagBerita', 'komentar'));
    }

    public function storeComment(Request $request, $id)
    {
        $rules = [
            'comment' => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $berita = Berita::findOrFail($id);

        $berita->komentar()->create([
            'id_user' => auth()->user()->id_user,
            'komentar' => $request->comment,
        ]);

        return redirect()->route('berita')->with('success', 'Comment added successfully.');
    }
}
