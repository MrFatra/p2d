@php
    function healthColor($value)
    {
        return match ($value) {
            'baik' => ['#22C55E', 'white'],
            'cukup' => ['#FACC15', 'black'],
            'kurang' => ['#EF4444', 'white'],
            default => ['white', 'black'],
        };
    }

    $headers = [
        'Nama Ayah',
        'Nama Ibu',
        'Nama Remaja',
        'Berat Badan',
        'Tinggi Badan',
        'BMI',
        'Tekanan Darah',
        'Anemia',
        'Tablet Tambah Darah',
        'Kesehatan Reproduksi',
        'Kesehatan Mental',
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
        @foreach ($teenagers as $teenager)
            @php
                [$bgRH, $textRH] = healthColor($teenager->reproductive_health);
                [$bgMH, $textMH] = healthColor($teenager->mental_health);
            @endphp

            <tr>
                <td>{{ $teenager->user?->fathe?r->name }}</td>
                <td>{{ $teenager->user?->mother?->name }}</td>
                <td style="text-align: left;">{{ $teenager->user->name }}</td>
                <td style="text-align: right;">{{ $teenager->weight }}</td>
                <td style="text-align: right;">{{ $teenager->height }}</td>
                <td style="text-align: right;">{{ $teenager->bmi }}</td>
                <td style="text-align: left;">{{ $teenager->blood_pressure }}</td>
                <td style="background-color: {{ $teenager->anemia ? '#EF4444' : '#22C55E' }}; color: white;">
                    {{ $teenager->anemia ? 'Ya' : 'Tidak' }}
                </td>
                <td>{{ $teenager->iron_tablets }}</td>
                <td style="background-color: {{ $bgRH }}; color: {{ $textRH }};">
                    {{ ucfirst($teenager->reproductive_health) }}
                </td>
                <td style="background-color: {{ $bgMH }}; color: {{ $textMH }};">
                    {{ ucfirst($teenager->mental_health) }}
                </td>
                <td>{{ $teenager->created_at->format('d/m/Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
