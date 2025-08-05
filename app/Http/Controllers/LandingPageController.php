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
            ->get()
            ->map(function ($schedule) {
                $typeMapping = [
                    'Donor' => 'Donor Darah',
                    'Infant Posyandu' => 'Posyandu Bayi',
                    'Toddler Posyandu' => 'Posyandu Balita',
                    'Pregnant Women Posyandu' => 'Posyandu Ibu Hamil',
                    'Teenager Posyandu' => 'Posyandu Remaja',
                    'Elderly Posyandu' => 'Posyandu Lansia',
                ];

                $schedule->type_label = $typeMapping[$schedule->type] ?? $schedule->type;
                $schedule->tanggal_label = \Carbon\Carbon::parse($schedule->date_open)->translatedFormat('l, d F Y');
                return $schedule;
            });

        $latestArticles = Article::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $babyCount = User::getUsers('baby')->count();
        $toddlerCount = User::getUsers('toddler')->count();
        $teenagerCount = User::getUsers('teenager')->count();
        $elderlyCount = User::getUsers('elderly')->count();

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
