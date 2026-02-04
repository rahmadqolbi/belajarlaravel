<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Tambah Data</title>
</head>
<body>
     <div class="container mt-3">
    <h3>Form Tambah Data Mahasiswa</h3>
 @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- 02. Form input data -->
                    @if ($errors->any())
                        {{-- any artinya apakah ada error di dalam inputan ini --}}
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

   <form action="{{ route('aktifitas.update', $data->id) }}" method="POST">

 @csrf
  @method('put')
    <input type="hidden" name="page" value="{{ request('page') }}">
    <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Nama</label>
  <input type="text" class="form-control w-50" id="exampleFormControlInput1" placeholder="Masukkan Nama" name="nama" value="{{ old('nama',$data->nama) }}">
</div>

    <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Alamat</label>
  <input type="text" class="form-control w-50" id="exampleFormControlInput1" placeholder="Masukkan Alamat" name="alamat" value="{{ old('alamat',$data->alamat) }}">
    </div>
         <div class="mt-3 ">
        <label for="agama" class="form-label ">Agama</label>
        <select
            class="form-select form-select-md w-50"
            name="agama"
            id="agama"
     >
            <option selected value="">-</option>
            <option value="ISLAM" {{ old('agama', $data->agama) == 'ISLAM' ? 'selected' :'' }}>ISLAM</option>
            <option value="KRISTEN" {{ old('agama', $data->agama) =='KRISTEN' ? 'selected' :'' }}>KRISTEN</option>
            <option value="BUDHA"{{ old('agama', $data->agama) =='BUDHA' ? 'selected' :'' }}>BUDHA</option>
              <option value="KATOLIK" {{ old('agama', $data->agama) =='KATOLIK' ? 'selected' :'' }}>KATOLIK</option>
        </select>
</div>
          <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">No Hp</label>
  <input type="text" class="form-control w-50" id="exampleFormControlInput1" placeholder="Masukkan No Hp" name="nohp" value="{{ old('nohp','0'.$data->nohp) }}">
    </div>
    <a href="{{ route('aktifitas') }}" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>

   </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
