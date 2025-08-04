@php
    function genderColor($gender)
    {
        return match ($gender) {
            'P' => ['Perempuan', '#F9A8D4', 'black'],
            'L' => ['Laki-laki', '#93C5FD', 'black'],
            default => [$gender, 'white', 'black'],
        };
    }

    $headers = [
        'Nomor KK',
        'NIK',
        'Nama',
        'Tanggal Lahir',
        'Jenis Kelamin',
        'Nomor Telepon',
        'RT',
        'RW',
        'Alamat Lengkap',
        'Dusun',
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
        @foreach ($users as $user)
            @php
                [$genderText, $genderBg, $genderColor] = genderColor($user->gender);
            @endphp
            <tr>
                <td>{{ $user->family_card_number }}</td>
                <td>{{ $user->national_id }}</td>
                <td>{{ $user->name }}</td>
                <td style="text-align: center;">
                    {{ \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') }}
                </td>
                <td style="background-color: {{ $genderBg }}; color: {{ $genderColor }}; text-align: center;">
                    {{ $genderText }}
                </td>
                <td>{{ $user->phone_number }}</td>
                <td style="text-align: center;">{{ $user->rt }}</td>
                <td style="text-align: center;">{{ $user->rw }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->hamlet }}</td>
                <td style="text-align: center;">
                    {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
