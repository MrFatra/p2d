@php
    function nutritionColor($value)
    {
        return match ($value) {
            'Gizi Baik' => ['#22C55E', 'white'],
            'Beresiko' => ['#FDBA74', 'black'],
            'Gizi Buruk' => ['#DC2626', 'white'],
            'Obesitas' => ['#8B5CF6', 'white'],
            default => ['white', 'black'],
        };
    }

    function functionalColor($value)
    {
        return match ($value) {
            'Mandiri' => ['#22C55E', 'white'],
            'Butuh Bantuan' => ['#FACC15', 'black'],
            'Tidak Mandiri' => ['#EF4444', 'white'],
            default => ['white', 'black'],
        };
    }

    $headers = [
        'Nama Lansia',
        'Tekanan Darah',
        'Glukosa Darah',
        'Kolesterol',
        'Status Gizi',
        'Kemampuan Fungsional',
        'Riwayat Penyakit Kronis',
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
        @foreach ($elderlies as $elderly)
            @php
                [$bgNutri, $colorNutri] = nutritionColor($elderly->nutrition_status);
                [$bgFunc, $colorFunc] = functionalColor($elderly->functional_ability);
            @endphp
            <tr>
                <td>{{ $elderly->user?->name ?? '-' }}</td>
                <td style="text-align: right;">{{ $elderly->blood_pressure }}</td>
                <td style="text-align: right;">{{ $elderly->blood_glucose }}</td>
                <td style="text-align: right;">{{ $elderly->cholesterol }}</td>
                <td style="background-color: {{ $bgNutri }}; color: {{ $colorNutri }}; text-align: center;">
                    {{ $elderly->nutrition_status }}
                </td>
                <td style="background-color: {{ $bgFunc }}; color: {{ $colorFunc }}; text-align: center;">
                    {{ $elderly->functional_ability }}
                </td>
                <td style="text-align: left;">{{ $elderly->chronic_disease_history }}</td>
                <td style="text-align: center;">{{ $elderly->created_at->format('d/m/Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
