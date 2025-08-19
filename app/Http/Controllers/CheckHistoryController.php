<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CheckHistoryController extends Controller
{
    public function index(Request $request)
    {
        $loggedUser = auth()->user();

        $startMonth = $request->get('start_month', 1);
        $endMonth   = $request->get('end_month', 12);
        $year       = $request->get('year', date('Y'));

        // Daftar relasi pemeriksaan
        $relations = [
            'Elderly'   => 'elderlies',
            'Infant'    => 'infants',
            'Pregnant'  => 'pregnantPostpartumBreastfeedings',
            'Teenager'  => 'teenagers',
            'Toddler'   => 'toddlers',
            'Adult'     => 'adults',
        ];

        $checkups = collect();

        foreach ($relations as $categoryName => $relation) {
            $users = User::with([$relation => function ($q) use ($year, $startMonth, $endMonth) {
                $q->whereYear('created_at', $year)
                    ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth]);
            }])
                ->where('id', $loggedUser->id) // 👈 filter user yang sedang login saja
                ->get()
                ->filter(fn($user) => $user->$relation->isNotEmpty())
                ->flatMap(function ($user) use ($relation, $categoryName) {
                    return $user->$relation->map(function ($checkup) use ($user, $categoryName) {
                        // hitung umur
                        $birthDate = $user->birth_date ? Carbon::parse($user->birth_date) : null;
                        $age = $birthDate ? $birthDate->diff(Carbon::now()) : null;

                        return [
                            'category'     => $categoryName,
                            'name'         => $user->name,
                            'nik'          => $user->national_id ?? '-',
                            'birth_date'   => $user->birth_date
                                ? Carbon::parse($user->birth_date)->translatedFormat('d F Y')
                                : '-',
                            'gender'       => match ($user->gender) {
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                                default => '-',
                            },
                            'checkup_date' => $checkup->checkup_date
                                ? Carbon::parse($checkup->checkup_date)->translatedFormat('d F Y')
                                : ($checkup->created_at?->translatedFormat('d F Y') ?? '-'),

                            // Usia
                            'age' => $age
                                ? ($age->y > 0
                                    ? $age->y . ' Tahun' // Hanya tampil tahun untuk Adult
                                    : ($age->m > 0
                                        ? $age->m . ' Bulan ' . $age->d . ' Hari'
                                        : $age->d . ' Hari'))
                                : '-',

                            // Data umum
                            'weight' => $checkup->weight ? $checkup->weight . ' kg' : '-',
                            'height' => $checkup->height ? $checkup->height . ' cm' : '-',
                            'status' => ucfirst($checkup->status ?? '-'),

                            // 🔥 Khusus Infant langsung di-level atas jika kategori Infant
                            'head_circumference'       => $categoryName === 'Infant' ? ($checkup->head_circumference ? $checkup->head_circumference . ' cm' : '-') : null,
                            'birth_weight'             => $categoryName === 'Infant' ? ($checkup->birth_weight ? $checkup->birth_weight . ' kg' : '-') : null,
                            'birth_height'             => $categoryName === 'Infant' ? ($checkup->birth_height ? $checkup->birth_height . ' cm' : '-') : null,
                            'nutrition_status'         => $categoryName === 'Infant' ? ($checkup->nutrition_status ?? '-') : null,
                            'complete_immunization'    => $categoryName === 'Infant' ? ($checkup->complete_immunization ? 'Lengkap' : 'Tidak Lengkap') : null,
                            'vitamin_a'                => $categoryName === 'Infant' ? ($checkup->vitamin_a ? 'Ya' : 'Tidak') : null,
                            'stunting_status'          => $categoryName === 'Infant' ? ($checkup->stunting_status ?? '-') : null,
                            'exclusive_breastfeeding'  => $categoryName === 'Infant' ? ($checkup->exclusive_breastfeeding ? 'Ya' : 'Tidak') : null,
                            'complementary_feeding'    => $categoryName === 'Infant' ? ($checkup->complementary_feeding ? 'Ya' : 'Tidak') : null,
                            'motor_development'        => $categoryName === 'Infant' ? ($checkup->motor_development ?? '-') : null,

                            // 🔥 Khusus Adult langsung di-level atas jika kategori Adult
                            'blood_pressure' => $categoryName === 'Adult' ? ($checkup->blood_pressure ? $checkup->blood_pressure . ' mmHg' : '-') : null,
                            'blood_glucose'  => $categoryName === 'Adult' ? ($checkup->blood_glucose ? $checkup->blood_glucose . ' mg/dL' : '-') : null,
                            'cholesterol'    => $categoryName === 'Adult' ? ($checkup->cholesterol ? $checkup->cholesterol . ' mg/dL' : '-') : null,
                            'bmi'            => $categoryName === 'Adult' ? ($checkup->bmi ? $checkup->bmi : '-') : null,

                            // 🔥 Khusus Toddler langsung di-level atas
                            'upper_arm_circumference' => $categoryName === 'Toddler'
                                ? ($checkup->upper_arm_circumference ? $checkup->upper_arm_circumference . ' cm' : '-')
                                : null,
                            'nutrition_status' => $categoryName === 'Toddler'
                                ? ($checkup->nutrition_status ?? '-')
                                : null,
                            'vitamin_a' => $categoryName === 'Toddler'
                                ? ($checkup->vitamin_a ? 'Ya' : 'Tidak')
                                : null,
                            'immunization_followup' => $categoryName === 'Toddler'
                                ? ($checkup->immunization_followup ? 'Ya' : 'Tidak')
                                : null,
                            'food_supplement' => $categoryName === 'Toddler'
                                ? ($checkup->food_supplement ? 'Ya' : 'Tidak')
                                : null,
                            'parenting_education' => $categoryName === 'Toddler'
                                ? ($checkup->parenting_education ? 'Ya' : 'Tidak')
                                : null,
                            'stunting_status' => $categoryName === 'Toddler'
                                ? ($checkup->stunting_status ?? '-')
                                : null,
                            'motor_development' => $categoryName === 'Toddler'
                                ? ($checkup->motor_development ?? '-')
                                : null,
                            'checkup_date' => $checkup->checkup_date
                                ? Carbon::parse($checkup->checkup_date)->translatedFormat('d F Y')
                                : ($checkup->created_at?->translatedFormat('d F Y') ?? '-'),

                            // 🔥 Khusus Elderly langsung di-level atas jika kategori Elderly
                            'blood_pressure' => $categoryName === 'Elderly' ? ($checkup->blood_pressure ? $checkup->blood_pressure . ' mmHg' : '-') : null,
                            'blood_glucose' => $categoryName === 'Elderly' ? ($checkup->blood_glucose ? $checkup->blood_glucose . ' mg/dL' : '-') : null,
                            'cholesterol' => $categoryName === 'Elderly' ? ($checkup->cholesterol ? $checkup->cholesterol . ' mg/dL' : '-') : null,
                            'nutrition_status' => $categoryName === 'Elderly' ? ($checkup->nutrition_status ?? '-') : null,
                            'functional_ability' => $categoryName === 'Elderly' ? ($checkup->functional_ability ?? '-') : null,
                            'chronic_disease_history' => $categoryName === 'Elderly' ? ($checkup->chronic_disease_history ?? '-') : null,

                        ];
                    });
                });

            $checkups = $checkups->merge($users);
        }
        return Inertia::render('CheckHistory', [
            'checkups'   => $checkups->values()->all(),
            'startMonth' => $startMonth,
            'endMonth'   => $endMonth,
            'year'       => $year,
        ]);
    }
}
