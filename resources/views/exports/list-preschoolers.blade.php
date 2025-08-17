@php
    use App\Helpers\Family;

    function boolColor($value)
    {
        return $value ? ['Ya', '#22C55E', 'white'] : ['Tidak', '#EF4444', 'white'];
    }

    function nutritionColor($value)
    {
        return match ($value) {
            'Gizi Baik' => ['#22C55E', 'white'],
            'Gizi Cukup' => ['#FDBA74', 'black'],
            'Gizi Kurang' => ['#F59E0B', 'black'],
            'Gizi Buruk' => ['#DC2626', 'white'],
            'Obesitas' => ['#8B5CF6', 'white'],
            default => ['white', 'black'],
        };
    }

    function motorColor($value)
    {
        return match ($value) {
            'Normal' => ['#22C55E', 'white'],
            'Perlu Pemantauan' => ['#FACC15', 'black'],
            'Terlambat' => ['#EF4444', 'white'],
            default => ['white', 'black'],
        };
    }

    $headers = [
        'Nama Ayah',
        'Nama Ibu',
        'Nama Anak',
        'Berat Badan (kg)',
        'Tinggi Badan (cm)',
        'Lingkar Kepala (cm)',
        'Lingkar Lengan Atas (cm)',
        'Status Gizi',
        'Perkembangan Motorik',
        'Perkembangan Bahasa',
        'Perkembangan Sosial',
        'Vitamin A',
        'Imunisasi Lengkap',
        'ASI Eksklusif',
        'MP-ASI',
        'Edukasi Pola Asuh',
        'Tanggal Pemeriksaan',
        'Dibuat Pada',
    ];
@endphp

<table border="1">
    <thead>
        <tr>
            @foreach ($headers as $header)
                <th style="background-color: #008970; color: #FFFFFF; text-align: center;">
                    {{ $header }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($preschoolers as $preschooler)
            @php
                $fatherName = Family::getFatherName($preschooler->user?->family_card_number);
                $motherName = Family::getMotherName($preschooler->user?->family_card_number);

                [$bgNutrition, $colorNutrition] = nutritionColor($preschooler->nutrition_status);
                [$bgMotor, $colorMotor] = motorColor($preschooler->motor_development);

                [$textVitA, $bgVitA, $colorVitA] = boolColor($preschooler->vitamin_a);
                [$textImun, $bgImun, $colorImun] = boolColor($preschooler->complete_immunization);
                [$textAsi, $bgAsi, $colorAsi] = boolColor($preschooler->exclusive_breastfeeding);
                [$textMpasi, $bgMpasi, $colorMpasi] = boolColor($preschooler->complementary_feeding);
                [$textParenting, $bgParenting, $colorParenting] = boolColor($preschooler->parenting_education);
            @endphp
            <tr>
                <td>{{ $fatherName }}</td>
                <td>{{ $motherName }}</td>
                <td>{{ $preschooler->user->name }}</td>
                <td style="text-align: right;">{{ $preschooler->weight }}</td>
                <td style="text-align: right;">{{ $preschooler->height }}</td>
                <td style="text-align: right;">{{ $preschooler->head_circumference }}</td>
                <td style="text-align: right;">{{ $preschooler->upper_arm_circumference }}</td>

                <td style="background-color: {{ $bgNutrition }}; color: {{ $colorNutrition }}; text-align: center;">
                    {{ $preschooler->nutrition_status }}
                </td>

                <td style="background-color: {{ $bgMotor }}; color: {{ $colorMotor }}; text-align: center;">
                    {{ $preschooler->motor_development }}
                </td>

                <td style="text-align: center;">{{ $preschooler->language_development }}</td>
                <td style="text-align: center;">{{ $preschooler->social_development }}</td>

                <td style="background-color: {{ $bgVitA }}; color: {{ $colorVitA }}; text-align: center;">
                    {{ $textVitA }}
                </td>

                <td style="background-color: {{ $bgImun }}; color: {{ $colorImun }}; text-align: center;">
                    {{ $textImun }}
                </td>

                <td style="background-color: {{ $bgAsi }}; color: {{ $colorAsi }}; text-align: center;">
                    {{ $textAsi }}
                </td>

                <td style="background-color: {{ $bgMpasi }}; color: {{ $colorMpasi }}; text-align: center;">
                    {{ $textMpasi }}
                </td>

                <td style="background-color: {{ $bgParenting }}; color: {{ $colorParenting }}; text-align: center;">
                    {{ $textParenting }}
                </td>

                <td style="text-align: center;">
                    {{ $preschooler->checkup_date ? \Carbon\Carbon::parse($preschooler->checkup_date)->format('d/m/Y') : '-' }}
                </td>

                <td style="text-align: center;">
                    {{ \Carbon\Carbon::parse($preschooler->created_at)->format('d/m/Y') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
