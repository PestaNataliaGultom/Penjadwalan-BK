<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <div class="container mt-5">
    <h1 class="mb-4">IKM Data</h1>
    <a href="{{ route('ikmdata.export') }}" class="btn btn-success mb-3">Export to Excel</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Usaha</th>
                <th>NIB</th>
                <th>Nama Pemilik</th>
                <th>Alamat Pemilik</th>
                <th>Alamat Usaha</th>
                <th>Kapasitas Bulan</th>
                <th>Kapasitas Tahun/th>
                <th>Halak</th>
                <th>PIRT</th>
                <th>BPOM<th>
                <th>Bidang Usaha</th>
</tr>
</thead>
<tbody>
    @foreach ($ikmData as $data)
    <tr>
        <td>{{ $data->id }}</td>
        <td>{{ $data->nama_usaha }}</td>
        <td>{{ $data->nib }}</td>
        <td>{{ $data->nama_pemilik }}</td>
        <td>{{ $data->alamat_pemilik }}</td>
        <td>{{ $data->alamat_usaha }}</td>
        <td>{{ $data->kapasitas_bulan }}</td>
        <td>{{ $data->kapasitas_tahun }}</td>
        <td>{{ $data->halal }}</td>
        <td>{{ $data->pirt }}</td>
        <td>{{ $data->bpom }}</td>
        <td>{{ $data->bidang_usaha }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

</body>
</html>