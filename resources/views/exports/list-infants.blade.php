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
        'Nama Bayi',
        'Berat Badan',
        'Tinggi Badan',
        'Lingkar Kepala',
        'Berat Lahir',
        'Panjang Lahir',
        'Tanggal Pemeriksaan',
        'Status Gizi',
        'Imunisasi Lengkap',
        'Vitamin A',
        'ASI Eksklusif',
        'MPASI',
        'Perkembangan Motorik',
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
        @foreach ($infants as $infant)
            @php
                $fatherName = Family::getFatherName($infant->user?->family_card_number);
                $motherName = Family::getMotherName($infant->user?->family_card_number);

                [$bgNutrition, $colorNutrition] = nutritionColor($infant->nutrition_status);
                [$bgMotor, $colorMotor] = motorColor($infant->motor_development);

                [$textImun, $bgImun, $colorImun] = boolColor($infant->complete_immunization);
                [$textVitA, $bgVitA, $colorVitA] = boolColor($infant->vitamin_a);
                [$textAsi, $bgAsi, $colorAsi] = boolColor($infant->exclusive_breastfeeding);
                [$textMpasi, $bgMpasi, $colorMpasi] = boolColor($infant->complementary_feeding);
            @endphp
            <tr>
                <td>{{ $fatherName }}</td>
                <td>{{ $motherName }}</td>
                <td>{{ $infant->user->name }}</td>
                <td style="text-align: right;">{{ $infant->weight }}</td>
                <td style="text-align: right;">{{ $infant->height }}</td>
                <td style="text-align: right;">{{ $infant->head_circumference }}</td>
                <td style="text-align: right;">{{ $infant->birth_weight }}</td>
                <td style="text-align: right;">{{ $infant->birth_length }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($infant->checkup_date)->format('d/m/Y') }}</td>

                <td style="background-color: {{ $bgNutrition }}; color: {{ $colorNutrition }}; text-align: center;">
                    {{ $infant->nutrition_status }}
                </td>

                <td style="background-color: {{ $bgImun }}; color: {{ $colorImun }}; text-align: center;">
                    {{ $textImun }}
                </td>

                <td style="background-color: {{ $bgVitA }}; color: {{ $colorVitA }}; text-align: center;">
                    {{ $textVitA }}
                </td>

                <td style="background-color: {{ $bgAsi }}; color: {{ $colorAsi }}; text-align: center;">
                    {{ $textAsi }}
                </td>

                <td style="background-color: {{ $bgMpasi }}; color: {{ $colorMpasi }}; text-align: center;">
                    {{ $textMpasi }}
                </td>

                <td style="background-color: {{ $bgMotor }}; color: {{ $colorMotor }}; text-align: center;">
                    {{ $infant->motor_development }}
                </td>

                <td style="text-align: center;">
                    {{ $infant->created_at->format('d/m/Y') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
