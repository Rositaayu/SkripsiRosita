<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Models\Wartawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPublish = Berita::where('status_berita', 3)->count();
        $jumlahProgress = Berita::where('status_berita', 2)->count();
        $jumlahPending = Berita::where('status_berita', 1)->count();
        $jumlahReview = Berita::where('status_berita', 0)->count();

        if (Auth::user()->role == 'wartawan') {
            $jumlahPublish = Berita::where('status_berita', 3)
                ->where('id_user', Auth::user()->id_user)
                ->count();
            $jumlahProgress = Berita::where('status_berita', 2)
                ->where('id_user', Auth::user()->id_user)
                ->count();
            $jumlahPending = Berita::where('status_berita', 1)
                ->where('id_user', Auth::user()->id_user)
                ->count();
            $jumlahReview = Berita::where('status_berita', 0)
                ->where('id_user', Auth::user()->id_user)
                ->count();
        }

        if (Auth::user()->role == 'editor') {
            $jumlahPublish = Berita::where('status_berita', 3)
                ->whereRelation('user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor)
                ->count();
            $jumlahProgress = Berita::where('status_berita', 2)
                ->whereRelation('user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor)
                ->count();
            $jumlahPending = Berita::where('status_berita', 1)
                ->whereRelation('user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor)
                ->count();
            $jumlahReview = Berita::where('status_berita', 0)
                ->whereRelation('user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor)
                ->count();
        }

        $kategori = KategoriBerita::distinct()->pluck('nama_kategori')->toArray();
        $tag = Tag::distinct()->pluck('nama_tag')->toArray();
        $wartawan = Wartawan::with('user:id_user,name')->get()->pluck('user.name')->toArray();

        return view('pages.index', compact('jumlahPublish', 'jumlahProgress', 'jumlahPending', 'jumlahReview', 'kategori', 'tag', 'wartawan'));
    }

    public function dayFilterKategori(Request $request)
    {
        if ($request->ajax()) {
            // ambil tanggal sekarang
            $date = date('Y-m-d');

            // Ambil daftar kategori berita yang unik
            $categories = KategoriBerita::distinct()->pluck('nama_kategori');

            // Filter data berdasarkan tanggal yang dipilih
            $dayData = Berita::with('user.wartawan.editor.user')->selectRaw('kategori_berita.nama_kategori, COUNT(*) as total')
                ->join('kategori_berita', 'berita.id_kategori_berita', '=', 'kategori_berita.id_kategori_berita')
                ->whereDate('berita.created_at', $date) // Hanya ambil data untuk tanggal tertentu
                ->groupBy('kategori_berita.nama_kategori');

            if (Auth::user()->role == 'wartawan') {
                $dayData->where('berita.id_user', Auth::user()->id_user);
            }

            if (Auth::user()->role == 'editor') {
                $dayData->whereRelation('user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor);
            }

            $dayData = $dayData->get();

            // Inisialisasi array untuk menyimpan jumlah kategori per hari
            $dayChartData = [];

            // Loop melalui daftar kategori
            foreach ($categories as $category) {
                // Cari data jumlah berita untuk kategori tertentu dalam hasil query
                $foundData = $dayData->firstWhere('nama_kategori', $category);

                // Jika data ditemukan, simpan jumlahnya, jika tidak, simpan 0
                if ($foundData) {
                    $dayChartData[] = $foundData->total;
                } else {
                    $dayChartData[] = 0;
                }
            }

            return response()->json($dayChartData);
        }
    }

    public function monthFilterKategori(Request $request)
    {
        if ($request->ajax()) {
            // Ambil bulan dan tahun sekarang
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Ambil daftar kategori berita yang unik
            $categories = KategoriBerita::distinct()->pluck('nama_kategori');

            // Filter data berdasarkan bulan dan tahun saat ini
            $monthData = Berita::with('user.wartawan.editor.user')->selectRaw('kategori_berita.nama_kategori, COUNT(*) as total')
                ->join('kategori_berita', 'berita.id_kategori_berita', '=', 'kategori_berita.id_kategori_berita')
                ->whereMonth('berita.created_at', $currentMonth) // Hanya ambil data untuk bulan ini
                ->whereYear('berita.created_at', $currentYear) // Hanya ambil data untuk tahun ini
                ->groupBy('kategori_berita.nama_kategori');

            if (Auth::user()->role == 'wartawan') {
                $monthData->where('berita.id_user', Auth::user()->id_user);
            }

            if (Auth::user()->role == 'editor') {
                $monthData->whereRelation('user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor);
            }

            $monthData = $monthData->get();

            // Inisialisasi array untuk menyimpan jumlah kategori per bulan
            $monthChartData = [];

            // Loop melalui daftar kategori
            foreach ($categories as $category) {
                // Cari data jumlah berita untuk kategori tertentu dalam hasil query
                $foundData = $monthData->firstWhere('nama_kategori', $category);

                // Jika data ditemukan, simpan jumlahnya, jika tidak, simpan 0
                if ($foundData) {
                    $monthChartData[] = $foundData->total;
                } else {
                    $monthChartData[] = 0;
                }
            }

            return response()->json($monthChartData);
        }
    }

    public function weekFilterKategori(Request $request)
    {
        if ($request->ajax()) {
            // Ambil tanggal awal dan akhir minggu ini
            $startOfWeek = date('Y-m-d');
            $endOfWeek = date('Y-m-d', strtotime('-7 days'));

            // Ambil daftar kategori berita yang unik
            $categories = KategoriBerita::distinct()->pluck('nama_kategori');

            // Filter data berdasarkan rentang tanggal minggu ini
            $weekData = Berita::with('user.wartawan.editor.user')->selectRaw('kategori_berita.nama_kategori, COUNT(*) as total')
                ->join('kategori_berita', 'berita.id_kategori_berita', '=', 'kategori_berita.id_kategori_berita')
                ->whereBetween('berita.created_at', [$startOfWeek, $endOfWeek]) // Hanya ambil data untuk minggu ini
                ->groupBy('kategori_berita.nama_kategori');

            if (Auth::user()->role == 'wartawan') {
                $weekData->where('berita.id_user', Auth::user()->id_user);
            }

            if (Auth::user()->role == 'editor') {
                $weekData->whereRelation('user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor);
            }

            $weekData = $weekData->get();

            // Inisialisasi array untuk menyimpan jumlah kategori per minggu
            $weekChartData = [];

            // Loop melalui daftar kategori
            foreach ($categories as $category) {
                // Cari data jumlah berita untuk kategori tertentu dalam hasil query
                $foundData = $weekData->firstWhere('nama_kategori', $category);

                // Jika data ditemukan, simpan jumlahnya, jika tidak, simpan 0
                if ($foundData) {
                    $weekChartData[] = $foundData->total;
                } else {
                    $weekChartData[] = 0;
                }
            }

            return response()->json($weekChartData);
        }
    }

    public function dayFilterTag(Request $request)
    {
        if ($request->ajax()) {
            // ambil tanggal sekarang
            $date = date('Y-m-d');

            // Ambil daftar kategori berita yang unik
            $tags = Tag::distinct()->pluck('nama_tag');

            // Filter data berdasarkan tanggal yang dipilih
            $dayData = Tag::with('tag_berita.berita.user.wartawan.editor.user')->selectRaw('tag.nama_tag, COUNT(*) as total')
                ->join('tag_berita', 'tag.id_tag', '=', 'tag_berita.id_tag')
                ->join('berita', 'tag_berita.id_berita', '=', 'berita.id_berita')
                ->whereDate('berita.created_at', $date) // Hanya ambil data untuk tanggal tertentu
                ->groupBy('tag.nama_tag');

            if (Auth::user()->role == 'wartawan') {
                $dayData->where('berita.id_user', Auth::user()->id_user);
            }

            if (Auth::user()->role == 'editor') {
                $dayData->whereRelation('tag_berita.berita.user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor);
            }

            $dayData = $dayData->get();

            // Inisialisasi array untuk menyimpan jumlah tag per hari
            $dayChartData = [];

            // Loop melalui daftar tag
            foreach ($tags as $tag) {
                // Cari data jumlah berita untuk tag tertentu dalam hasil query
                $foundData = $dayData->firstWhere('nama_tag', $tag);

                // Jika data ditemukan, simpan jumlahnya, jika tidak, simpan 0
                if ($foundData) {
                    $dayChartData[] = $foundData->total;
                } else {
                    $dayChartData[] = 0;
                }
            }

            return response()->json($dayChartData);
        }
    }

    public function monthFilterTag(Request $request)
    {
        if ($request->ajax()) {
            // Ambil bulan dan tahun sekarang
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Ambil daftar kategori berita yang unik
            $tags = Tag::distinct()->pluck('nama_tag');

            // Filter data berdasarkan tanggal yang dipilih
            $monthData = Tag::with('tag_berita.berita.user.wartawan.editor.user')->selectRaw('tag.nama_tag, COUNT(*) as total')
                ->join('tag_berita', 'tag.id_tag', '=', 'tag_berita.id_tag')
                ->join('berita', 'tag_berita.id_berita', '=', 'berita.id_berita')
                ->whereMonth('berita.created_at', $currentMonth) // Hanya ambil data untuk bulan ini
                ->whereYear('berita.created_at', $currentYear) // Hanya ambil data untuk tahun ini
                ->groupBy('tag.nama_tag');

            if (Auth::user()->role == 'wartawan') {
                $monthData->where('berita.id_user', Auth::user()->id_user);
            }

            if (Auth::user()->role == 'editor') {
                $monthData->whereRelation('tag_berita.berita.user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor);
            }

            $monthData = $monthData->get();

            // Inisialisasi array untuk menyimpan jumlah tag per bulan
            $monthChartData = [];

            // Loop melalui daftar tag
            foreach ($tags as $tag) {
                // Cari data jumlah berita untuk tag tertentu dalam hasil query
                $foundData = $monthData->firstWhere('nama_tag', $tag);

                // Jika data ditemukan, simpan jumlahnya, jika tidak, simpan 0
                if ($foundData) {
                    $monthChartData[] = $foundData->total;
                } else {
                    $monthChartData[] = 0;
                }
            }

            return response()->json($monthChartData);
        }
    }

    public function weekFilterTag(Request $request)
    {
        if ($request->ajax()) {
            // Ambil tanggal awal dan akhir minggu ini
            $startOfWeek = date('Y-m-d');
            $endOfWeek = date('Y-m-d', strtotime('-7 days'));

            // Ambil daftar kategori berita yang unik
            $tags = Tag::distinct()->pluck('nama_tag');

            // Filter data berdasarkan tanggal yang dipilih
            $weekData = Tag::with('tag_berita.berita.user.wartawan.editor.user')->selectRaw('tag.nama_tag, COUNT(*) as total')
                ->join('tag_berita', 'tag.id_tag', '=', 'tag_berita.id_tag')
                ->join('berita', 'tag_berita.id_berita', '=', 'berita.id_berita')
                ->whereBetween('berita.created_at', [$startOfWeek, $endOfWeek]) // Hanya ambil data untuk minggu ini
                ->groupBy('tag.nama_tag');

            if (Auth::user()->role == 'wartawan') {
                $weekData->where('berita.id_user', Auth::user()->id_user);
            }

            if (Auth::user()->role == 'editor') {
                $weekData->whereRelation('tag_berita.berita.user.wartawan.editor', 'id_editor', Auth::user()->editor->id_editor);
            }

            $weekData = $weekData->get();

            // Inisialisasi array untuk menyimpan jumlah tag per minggu
            $weekChartData = [];

            // Loop melalui daftar tag
            foreach ($tags as $tag) {
                // Cari data jumlah berita untuk tag tertentu dalam hasil query
                $foundData = $weekData->firstWhere('nama_tag', $tag);

                // Jika data ditemukan, simpan jumlahnya, jika tidak, simpan 0
                if ($foundData) {
                    $weekChartData[] = $foundData->total;
                } else {
                    $weekChartData[] = 0;
                }
            }

            return response()->json($weekChartData);
        }
    }

    public function dayFilterWartawan(Request $request)
    {
        if ($request->ajax()) {
            // ambil tanggal sekarang
            $date = date('Y-m-d');

            // Query untuk mengambil 5 wartawan teratas
            $topWartawan = Wartawan::select('user.name', DB::raw('COUNT(berita.id_berita) AS total_berita'))
                ->join('user', 'wartawan.id_user', '=', 'user.id_user')
                ->join('berita', 'wartawan.id_user', '=', 'berita.id_user')
                ->whereDate('berita.created_at', $date)
                ->groupBy('user.id_user')
                ->orderByDesc('total_berita')
                ->limit(5)
                ->get();

            // Inisialisasi array untuk menyimpan jumlah berita per wartawan
            $jumlahBerita = [];

            // Loop melalui hasil query dan memasukkan jumlah berita ke dalam array
            foreach ($topWartawan as $wartawan) {
                $jumlahBerita[] = $wartawan->total_berita;
            }

            return response()->json($jumlahBerita);
        }
    }
    public function monthFilterWartawan(Request $request)
    {
        if ($request->ajax()) {
            // Ambil bulan dan tahun sekarang
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Query untuk mengambil 5 wartawan teratas
            $topWartawan = Wartawan::select('user.name', DB::raw('COUNT(berita.id_berita) AS total_berita'))
                ->join('user', 'wartawan.id_user', '=', 'user.id_user')
                ->join('berita', 'wartawan.id_user', '=', 'berita.id_user')
                ->whereMonth('berita.created_at', $currentMonth) // Hanya ambil data untuk bulan ini
                ->whereYear('berita.created_at', $currentYear) // Hanya ambil data untuk tahun ini
                ->groupBy('user.id_user')
                ->orderByDesc('total_berita')
                ->limit(5)
                ->get();

            // Inisialisasi array untuk menyimpan jumlah berita per wartawan
            $jumlahBerita = [];

            // Loop melalui hasil query dan memasukkan jumlah berita ke dalam array
            foreach ($topWartawan as $wartawan) {
                $jumlahBerita[] = $wartawan->total_berita;
            }

            return response()->json($jumlahBerita);
        }
    }

    public function weekFilterWartawan(Request $request)
    {
        if ($request->ajax()) {
            // Ambil tanggal awal dan akhir minggu ini
            $startOfWeek = date('Y-m-d');
            $endOfWeek = date('Y-m-d', strtotime('-7 days'));

            // Query untuk mengambil 5 wartawan teratas
            $topWartawan = Wartawan::select('user.name', DB::raw('COUNT(berita.id_berita) AS total_berita'))
                ->join('user', 'wartawan.id_user', '=', 'user.id_user')
                ->join('berita', 'wartawan.id_user', '=', 'berita.id_user')
                ->whereBetween('berita.created_at', [$startOfWeek, $endOfWeek]) // Hanya ambil data untuk minggu ini
                ->groupBy('user.id_user')
                ->orderByDesc('total_berita')
                ->limit(5)
                ->get();

            // Inisialisasi array untuk menyimpan jumlah berita per wartawan
            $jumlahBerita = [];

            // Loop melalui hasil query dan memasukkan jumlah berita ke dalam array
            foreach ($topWartawan as $wartawan) {
                $jumlahBerita[] = $wartawan->total_berita;
            }

            return response()->json($jumlahBerita);
        }
    }
}
