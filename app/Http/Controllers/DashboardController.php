<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!haveAccessTo('view_dashboard')) {
            abort(403);
        }


        $user = Auth::user();
        $role = $user->role->nama;

        if ($role === 'admin instansi') {
            $buku = Buku::with('instansi')->count();
        } else {
            $buku = Buku::count();
        }

        $now = Carbon::now();
        $currentYear = $now->year;
        $years = range($currentYear, $currentYear - 4);
        $selectedYear = $request->query('year', $currentYear);

        $periods = [
            'lastMonth' => [
                'start' => $now->copy()->subMonth()->startOfMonth(),
                'end' => $now->copy()->subMonth()->endOfMonth(),
            ],
            'currentMonth' => [
                'start' => $now->copy()->startOfMonth(),
                'end' => $now->copy()->endOfMonth(),
            ],
        ];

        $totals = [
            'users' => User::count(),
            'buku' => Buku::count(),
            'instansi' => Instansi::count(),
            'download' => Buku::sum('total_download'),
            'viewBuku' => Buku::whereYear('created_at', $selectedYear)->sum('total_read'),
        ];

        $getMonthlyData = function ($model, $field = 'created_at') use ($periods) {
            return [
                'last' => $model::whereBetween($field, [$periods['lastMonth']['start'], $periods['lastMonth']['end']])->count(),
                'current' => $model::whereBetween($field, [$periods['currentMonth']['start'], $periods['currentMonth']['end']])->count(),
            ];
        };

        $monthlyData = [
            'users' => $getMonthlyData(User::class),
            'buku' => $getMonthlyData(Buku::class),
            'instansi' => $getMonthlyData(Instansi::class),
            'download' => [
                'last' => Buku::whereBetween('created_at', [$periods['lastMonth']['start'], $periods['lastMonth']['end']])->sum('total_download'),
                'current' => Buku::whereBetween('created_at', [$periods['currentMonth']['start'], $periods['currentMonth']['end']])->sum('total_download'),
            ],
        ];

        $calculateGrowth = fn($current, $last) => [
            'growth' => round(abs($last ? (($current - $last) / $last) * 100 : $current * 100), 2),
            'trend' => $current >= $last ? 'up' : 'down',
        ];

        $data = [
            'totalUsers' => $totals['users'],
            'userGrowth' => $calculateGrowth($monthlyData['users']['current'], $monthlyData['users']['last'])['growth'],
            'userTrend' => $calculateGrowth($monthlyData['users']['current'], $monthlyData['users']['last'])['trend'],

            'totalBuku' => $totals['buku'],
            'bukuGrowth' => $calculateGrowth($monthlyData['buku']['current'], $monthlyData['buku']['last'])['growth'],
            'bukuTrend' => $calculateGrowth($monthlyData['buku']['current'], $monthlyData['buku']['last'])['trend'],

            'totalInstansi' => $totals['instansi'],
            'instansiGrowth' => $calculateGrowth($monthlyData['instansi']['current'], $monthlyData['instansi']['last'])['growth'],
            'instansiTrend' => $calculateGrowth($monthlyData['instansi']['current'], $monthlyData['instansi']['last'])['trend'],

            'totalDownload' => $totals['download'],
            'downloadGrowth' => $calculateGrowth($monthlyData['download']['current'], $monthlyData['download']['last'])['growth'],
            'downloadTrend' => $calculateGrowth($monthlyData['download']['current'], $monthlyData['download']['last'])['trend'],

            'totalViewBuku' => $totals['viewBuku'],
        ];

        return view('pages.admin.dashboard', compact('data', 'years', 'selectedYear'));
    }


    public function getChartData(Request $request)
    {
        $year = $request->query('year', date('Y'));

        $userRegistrations = User::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $userAtSelectedYear = User::whereYear('created_at', $year)->count();

        return response()->json([
            'registrations' => $userRegistrations,
            'dataUser' => $userAtSelectedYear
        ]);
    }
}
