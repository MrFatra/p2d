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
        'Nama',
        'BMI',
        'Tekanan Darah',
        'Diabetes',
        'Hipertensi',
        'Kolesterol',
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
        @foreach ($adults as $adult)
            @php
                [$bgMH, $textMH] = healthColor($adult->mental_health);
            @endphp

            <tr>
                <td style="text-align: left;">{{ $adult->user?->name }}</td>
                <td style="text-align: right;">{{ $adult->bmi }}</td>
                <td style="text-align: left;">{{ $adult->blood_pressure }}</td>

                <td style="background-color: {{ $adult->diabetes ? '#EF4444' : '#22C55E' }}; color: white;">
                    {{ $adult->diabetes ? 'Ya' : 'Tidak' }}
                </td>

                <td style="background-color: {{ $adult->hypertension ? '#EF4444' : '#22C55E' }}; color: white;">
                    {{ $adult->hypertension ? 'Ya' : 'Tidak' }}
                </td>

                <td style="background-color: {{ $adult->cholesterol ? '#EF4444' : '#22C55E' }}; color: white;">
                    {{ $adult->cholesterol ? 'Ya' : 'Tidak' }}
                </td>

                <td>{{ $adult->created_at->format('d/m/Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
