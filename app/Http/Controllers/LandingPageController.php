<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PregnantPostpartumBreastfeending;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingPageController extends Controller
{
    public function index()
    {

        // Ambil jadwal untuk bulan sekarang
        $now = now();

        $schedules = Schedule::whereMonth('date_open', $now->month)
            ->whereYear('date_open', $now->year)
            ->orderBy('date_open', 'asc')
            ->get();

        $latestArticles = Article::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        $babyCount = User::role('baby')->count();
        $toddlerCount = User::role('toddler')->count();
        $teenagerCount = User::role('teenager')->count();
        $elderlyCount = User::role('elderly')->count();

        $nineMonthsAgo = $now->copy()->subMonths(9);

        $pregnantCount = PregnantPostpartumBreastfeending::where('created_at', '>=', $nineMonthsAgo)
            ->distinct('user_id')
            ->count('user_id');

        $statistic =  [
            'baby' => $babyCount,
            'toddler' => $toddlerCount,
            'teenager' => $teenagerCount,
            'elderly' => $elderlyCount,
            'pregnant' => $pregnantCount,
        ];

        return Inertia::render('Home', [
            'schedules' => $schedules,
            'articles' => $latestArticles,
            'statistics' => $statistic
        ]);
    }
}
