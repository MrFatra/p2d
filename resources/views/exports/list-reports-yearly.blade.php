@php

    $hasHamlet = $reports->contains(fn($report) => !is_null($report->hamlet));

    $headers = [
        'Lansia (60 Tahun ke Atas)',
        'Bayi (0-12 Bulan)',
        'Ibu Hamil',
        'Remaja (13-17 Tahun)',
        'Balita (1-5 Tahun)',
    ];

    if ($hasHamlet) {
        $headers[] = 'Dusun';
    }

    $headers[] = 'Tahun';

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
        @foreach ($reports as $report)
            <tr>
                <td style="text-align: center;">{{ $report->elderlies }}</td>
                <td style="text-align: center;">{{ $report->babies }}</td>
                <td style="text-align: center;">{{ $report->pregnants }}</td>
                <td style="text-align: center;">{{ $report->teenagers }}</td>
                <td style="text-align: center;">{{ $report->toddlers }}</td>
                @if ($hasHamlet)
                    <td style="text-align: center;">{{ $report->hamlet }}</td>
                @endif
                <td style="text-align: center;">{{ $report->year }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
