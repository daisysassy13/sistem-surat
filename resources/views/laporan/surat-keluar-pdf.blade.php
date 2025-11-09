<!DOCTYPE html>
<html>
<head>
    <title>Laporan Surat Keluar</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #27ae60; color: white; }
        h2 { text-align: center; color: #27ae60; }
    </style>
</head>
<body>
    <h2>LAPORAN SURAT KELUAR</h2>
    <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Surat</th>
                <th>Tanggal</th>
                <th>Tujuan</th>
                <th>Perihal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $surat)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $surat->nomor_surat }}</td>
                <td>{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
                <td>{{ $surat->tujuan_surat }}</td>
                <td>{{ $surat->perihal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p style="margin-top: 30px;">Total: {{ $data->count() }} surat</p>
</body>
</html>