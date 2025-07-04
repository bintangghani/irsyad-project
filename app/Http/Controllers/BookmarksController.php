<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Kelompok;
use App\Models\SubKelompok;
use App\Services\CommonDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class BookmarksController extends Controller
{
    public function index()
    {
        if (!haveAccessTo('read_buku')) {
            return redirect()->back();
        }

        $data = CommonDataService::getCommonData([
            'user' => Auth::user()
        ]);

        $data['subcategories'] = SubKelompok::withCount('buku')
            ->orderByDesc('buku_count')
            ->take(6)
            ->get();

        $data['bookmark'] = Bookmark::where('id_user', Auth::user()->id_user)->get();

        $data['categories'] = Kelompok::with('buku')->get()->map(function ($category) {
            $category->nuku = $category->buku(); // Pastikan ini maksudnya "buku", typo?
            return $category;
        });

        return view('pages.user.buku.bookmarks.index', $data);
    }


    public function store(Request $request)
    {
        if (!haveAccessTo('read_buku')) {
            return redirect()->back();
        }
        try {
            $validated = $request->validate([
                'id_user' => 'required|uuid|exists:users,id_user',
                'id_buku' => 'required|uuid|exists:buku,id_buku',
            ], [
                'id_user.required' => 'ID User wajib',
                'id_buku.required' => 'ID Buku wajib',
            ]);

            $existingBookmark = Bookmark::where('id_user', $validated['id_user'])
                ->where('id_buku', $validated['id_buku'])
                ->first();

            if ($existingBookmark) {
                Alert::info('Info', 'Buku ini sudah di-bookmark.');
                return redirect()->back()->with('info', 'Buku ini sudah di-bookmark.');
            }

            Bookmark::create([
                'id_user' => $validated['id_user'],
                'id_buku' => $validated['id_buku'],
            ]);

            Alert::success('Success', 'Bookmarks berhasil ditambahkan.');
            return redirect()->route('dashboard.bookmarks.index')->with('success', 'Bookmarks berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Throwable $th) {
            Log::error('Error storing bookmarks: ' . $th->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }


    public function destroy($id)
    {
        if (!haveAccessTo('read_buku')) {
            return redirect()->back();
        }
        try {
            $bookmark = Bookmark::findOrFail($id);
            $bookmark->delete();
            Alert::success('Success', 'Bookmarks berhasil dihapus');
            return redirect()->route('dashboard.bookmarks.index')->with('success', 'Bookmarks berhasil dihapus!');
        } catch (\Throwable $th) {
            Log::error('Error deleting bookmarks: ' . $th->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }
}
