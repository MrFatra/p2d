@php
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
            'Gizi Obesitas' => ['#8B5CF6', 'white'],
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
        'Nama',
        'Berat Badan',
        'Tinggi Badan',
        'Lingkar Lengan Atas',
        'Status Gizi',
        'Vitamin A',
        'Pemeriksaan Lanjutan Imunisasi',
        'Suplemen Makanan',
        'Edukasi Orang Tua',
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
        @foreach ($toddlers as $toddler)
            @php
                [$textVitA, $bgVitA, $textColorVitA] = boolColor($toddler->vitamin_a);
                [$textImm, $bgImm, $textColorImm] = boolColor($toddler->immunization_followup);
                [$textSupp, $bgSupp, $textColorSupp] = boolColor($toddler->food_supplement);
                [$textEdu, $bgEdu, $textColorEdu] = boolColor($toddler->parenting_education);

                [$bgNutri, $textNutri] = nutritionColor($toddler->nutrition_status);
                [$bgMotor, $textMotor] = motorColor($toddler->motor_development);
            @endphp

            <tr>
                <td>{{ $toddler->user->name }}</td>
                <td style="text-align: right;">{{ $toddler->weight }}</td>
                <td style="text-align: right;">{{ $toddler->height }}</td>
                <td style="text-align: right;">{{ $toddler->upper_arm_circumference }}</td>

                <td style="background-color: {{ $bgNutri }}; color: {{ $textNutri }};">
                    {{ $toddler->nutrition_status }}
                </td>

                <td style="background-color: {{ $bgVitA }}; color: {{ $textColorVitA }}; text-align: center;">
                    {{ $textVitA }}
                </td>
                <td style="background-color: {{ $bgImm }}; color: {{ $textColorImm }}; text-align: center;">
                    {{ $textImm }}
                </td>
                <td style="background-color: {{ $bgSupp }}; color: {{ $textColorSupp }}; text-align: center;">
                    {{ $textSupp }}
                </td>
                <td style="background-color: {{ $bgEdu }}; color: {{ $textColorEdu }}; text-align: center;">
                    {{ $textEdu }}
                </td>

                <td style="background-color: {{ $bgMotor }}; color: {{ $textMotor }};">
                    {{ $toddler->motor_development }}
                </td>

                <td style="text-align: center;">
                    {{ $toddler->created_at->format('d/m/Y') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
