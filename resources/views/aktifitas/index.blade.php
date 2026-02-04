<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Data Mahasiswa!</title>
  </head>
  <body>


    <div class="container">
<h1>Data Mahasiswa!</h1>
        <div class="mb-3">
            <form action="{{ route('aktifitas') }}" method="get">
       <label for="search" class="form-label" value="{{ request('search') }}">Search</label>
            <input
                type="text"
                class="form-control w-50"
                name="search"
                id=""
                aria-describedby="helpId"
                placeholder="Masukkan Nama"
            />

        </div>
            <button type="submit" class="btn btn-primary">Search</button>

            </form>


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        @if (session('destroy'))
        <div class="alert alert-danger">
            {{ session('destroy') }}
        </div>

        @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Agama</th>
                <th>No Hp</th>
                <th colspan="2">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $item)

            <tr>
                <td>{{ $data->firstItem() + $loop->index }}</td>
                <td>{{ strtoupper($item->nama) }}</td>
                <td>{{ strtoupper($item->alamat) }}</td>
                <td>{{ strtoupper($item->agama) }}</td>
                <td>0{{ $item->nohp }}</td>
                <td>
                    <a href="{{ route('aktifitas.update',['id' => $item->id, 'page' => request('page')])}}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('aktifitas.destroy',['id' => $item->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin Ingin Hapus Data ?')">
                        @csrf
                        @method('DELETE')
                      <button type="submit" class="btn btn-danger">Delete</button>

                    </form>
                </td>

            </tr>
            @endforeach


        </tbody>
</table>
    <div class="d-flex justify-content-end">
    {{ $data->links() }}
</div>
<a href="{{ route('aktifitas.add') }}" class="btn btn-primary">Tambah Data</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
