<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Buku;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    if (!haveAccessTo('view_dashboard')) {
        abort(403);
    }

    $currentYear = date('Y');
    $years = range($currentYear, $currentYear - 5); // 5 tahun terakhir

    $selectedYear = $request->query('year', $currentYear); // Tahun default = sekarang

    $now = Carbon::now();
    $lastMonthStart = $now->subMonth()->startOfMonth();
    $lastMonthEnd = $now->endOfMonth();

    $totalUsers = User::count();
    $totalBuku = Buku::count();
    $totalInstansi = Instansi::count();
    $totalDownload = Buku::sum('total_download');

    $totalViewBuku = Buku::whereYear('created_at', $selectedYear)->sum('total_read');

    $lastMonthUsers = User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
    $lastMonthBuku = Buku::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
    $lastMonthInstansi = Instansi::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
    $lastMonthDownload = Buku::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('total_download');

    $calculateGrowth = function ($current, $lastMonth) {
        if ($lastMonth > 0) {
            $growth = (($current - $lastMonth) / $lastMonth) * 100;
            return ['growth' => round(abs($growth), 2), 'trend' => $growth >= 0 ? 'up' : 'down'];
        }
        return ['growth' => 0, 'trend' => 'up'];
    };

    $userStats = $calculateGrowth($totalUsers, $lastMonthUsers);
    $bukuStats = $calculateGrowth($totalBuku, $lastMonthBuku);
    $instansiStats = $calculateGrowth($totalInstansi, $lastMonthInstansi);
    $downloadStats = $calculateGrowth($totalDownload, $lastMonthDownload);

    $data = [
        'totalUsers' => $totalUsers,
        'userGrowth' => $userStats['growth'],
        'userTrend' => $userStats['trend'],
        'totalBuku' => $totalBuku,
        'bukuGrowth' => $bukuStats['growth'],
        'bukuTrend' => $bukuStats['trend'],
        'totalInstansi' => $totalInstansi,
        'instansiGrowth' => $instansiStats['growth'],
        'instansiTrend' => $instansiStats['trend'],
        'totalDownload' => $totalDownload,
        'downloadGrowth' => $downloadStats['growth'],
        'downloadTrend' => $downloadStats['trend'],
        'totalViewBuku' => $totalViewBuku,
    ];

    return view('pages.admin.dashboard', compact('data', 'years', 'selectedYear'));
}

    public function getChartData(Request $request)
    {
        $year = $request->query('year', date('Y'));
        $previousYear = $year - 1;

        $totalReadsThisYear = Buku::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_read) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $totalReadsLastYear = Buku::whereYear('created_at', $previousYear)
            ->selectRaw('MONTH(created_at) as month, SUM(total_read) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Konversi data tahun lalu menjadi negatif agar muncul di bawah
        $formattedLastYear = array_map(fn($value) => -abs($value), $totalReadsLastYear);

        return response()->json([
            'thisYear' => $totalReadsThisYear,
            'lastYear' => $formattedLastYear, // Data dibuat negatif
        ]);
    }
}
