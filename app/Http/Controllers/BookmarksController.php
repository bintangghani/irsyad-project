<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class BookmarksController extends Controller
{
    public function index()
    {
        $bookmark = Bookmark::where('id_user', Auth::user()->id_user)->get();
        return view('pages.user.buku.bookmarks.index', compact('bookmark'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_user' => 'required|uuid|exists:users,id_user',
                'id_buku' => 'required|uuid|exists:buku,id_buku',
            ], [
                'id_user.required' => 'ID User wajib',
                'id_buku.required' => 'ID Buku wajib',
            ]);

            // Periksa apakah bookmark sudah ada
            $existingBookmark = Bookmark::where('id_user', $validated['id_user'])
                ->where('id_buku', $validated['id_buku'])
                ->first();

            if ($existingBookmark) {
                // Jika sudah di-bookmark, tampilkan alert
                Alert::info('Info', 'Buku ini sudah di-bookmark.');
                return redirect()->back()->with('info', 'Buku ini sudah di-bookmark.');
            }

            // Jika belum di-bookmark, tambahkan bookmark
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
        try{
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
