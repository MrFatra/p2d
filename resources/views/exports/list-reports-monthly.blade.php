@php

    $hasHamlet = $reports->contains(fn($report) => !is_null($report->hamlet));

    $headers = [
        'Bayi (0-12 Bulan)',
        'Balita (1-5 Tahun)',
        'Anak Pra Sekolah (6-12 Tahun)',
        'Remaja (13-17 Tahun)',
        'Dewasa (18-59 Tahun)',
        'Lansia (60 Tahun ke Atas)',
        'Ibu Hamil',
    ];

    if ($hasHamlet) {
        $headers[] = 'Dusun';
    }

    $headers[] = 'Bulan';
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
                <td style="text-align: center;">{{ $report->babies }}</td>
                <td style="text-align: center;">{{ $report->toddlers }}</td>
                <td style="text-align: center;">{{ $report->children }}</td>
                <td style="text-align: center;">{{ $report->teenagers }}</td>
                <td style="text-align: center;">{{ $report->adults }}</td>
                <td style="text-align: center;">{{ $report->elderlies }}</td>
                <td style="text-align: center;">{{ $report->pregnants }}</td>
                @if ($hasHamlet)
                    <td style="text-align: center;">{{ $report->hamlet }}</td>
                @endif
                <td style="text-align: center;">
                    {{ \Carbon\Carbon::create()->month((int) $report->month)->translatedFormat('F') }}
                </td>
                <td style="text-align: center;">{{ $report->year }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
