@php
    function pregnancyStatusColor($status)
    {
        return match ($status) {
            'trimester 1' => ['#93C5FD', 'black'],
            'trimester 2' => ['#60A5FA', 'white'],
            'trimester 3' => ['#2563EB', 'white'],
            'postpartum' => ['#34D399', 'white'],
            'pregnant' => ['#FBBF24', 'black'],
            'abortus' => ['#EF4444', 'white'],
            default => ['#E5E7EB', 'black'],
        };
    }

    function statusLabel($status)
    {
        return match ($status) {
            'trimester 1' => 'Trimester 1',
            'trimester 2' => 'Trimester 2',
            'trimester 3' => 'Trimester 3',
            'pregnant'    => 'Hamil',
            'postpartum'  => 'Nifas',
            'abortus'     => 'Keguguran',
            'none'        => 'Tidak Hamil',
            default       => '-',
        };
    }

    $headers = [
        'Nama',
        'Status Kehamilan',
        'Lingkar Lengan Atas (LILA)',
        'Tekanan Darah',
        'Imunisasi Tetanus',
        'Tablet Tambah Darah',
        'Jadwal ANC',
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
        @foreach ($pregnants as $pregnant)
            @php
                [$bgStatus, $textStatus] = pregnancyStatusColor($pregnant->pregnancy_status);
            @endphp
            <tr>
                <td>{{ $pregnant->user->name ?? '-' }}</td>

                <td style="background-color: {{ $bgStatus }}; color: {{ $textStatus }};">
                    {{ statusLabel($pregnant->pregnancy_status) }}
                </td>

                <td style="text-align: right;">
                    {{ $pregnant->muac ?? '-' }}
                </td>

                <td style="text-align: right;">
                    {{ $pregnant->blood_pressure ?? '-' }}
                </td>

                <td style="text-align: center;">
                    {{ $pregnant->tetanus_immunization ?? '-' }}
                </td>

                <td style="text-align: center;">
                    {{ $pregnant->iron_tablets !== null ? $pregnant->iron_tablets . ' Tablet' : '-' }}
                </td>

                <td style="text-align: center;">
                    {{ $pregnant->anc_schedule ? \Carbon\Carbon::parse($pregnant->anc_schedule)->format('d/m/Y') : '-' }}
                </td>

                <td style="text-align: center;">
                    {{ $pregnant->created_at->format('d/m/Y') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
