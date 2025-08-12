@php
    use App\Helpers\MonthlyReport;

    $headers = [
        'Lansia (60 Tahun ke Atas)',
        'Bayi (0-12 Bulan)',
        'Ibu Hamil',
        'Remaja (13-17 Tahun)',
        'Balita (1-5 Tahun)',
        'Bulan',
        'Tahun',
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
        @foreach ($reports as $report)
            @php
                $data = MonthlyReport::getMonthlyReportByRecord($report);
            @endphp
            <tr>
                <td style="text-align: center;">{{ $data['Elderly'] }}</td>
                <td style="text-align: center;">{{ $data['Infant'] }}</td>
                <td style="text-align: center;">{{ $data['Pregnant'] }}</td>
                <td style="text-align: center;">{{ $data['Teenager'] }}</td>
                <td style="text-align: center;">{{ $data['Toddler'] }}</td>
                <td style="text-align: center;">{{ $data['month'] }}</td>
                <td style="text-align: center;">{{ $data['year'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
