<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="css/plugins/select2/select2.min.css" rel="stylesheet">
</head>

<body class="white-bg d-flex justify-content-center align-items-center">
    <div class="card p-5 middle-box text-center animated fadeInDown">
        <div>
            <div>
                <img class="logo-img" src="{{ asset('img/masjid.png') }}">
            </div>
            <h3>Daftarkan diri anda</h3>
            <p>Pengingat sholat melalui whatsapp</p>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form class="m-t" method="POST" action="{{ route('masyarakat.store') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="nama" class="form-control" placeholder="Nama anda" required>
                </div>

                <div class="form-group">
                    <input type="text" name="no_hp" class="form-control" placeholder="No Whatsapp" required>
                </div>

                <div class="form-group">
                    <select name="gender" class="form-control" placeholder="Jenis Kelamin" required>
                        <option value="">Pilih Jenis Kelamin Anda</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <select name="id_kabupaten" class="select2_demo_3 form-control border border-primary"required>
                        <option></option>
                        @foreach ($kabupatens as $kab)
                            <option value="{{ $kab->id }}">{{ $kab->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Daftar</button>
            </form>
            <p class="m-t"> <small>Masjid Ainun Jariyah | Klurak Baru RT.01 &copy; 2015</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Select2 -->
    <script src="js/plugins/select2/select2.full.min.js"></script>

    <script>
        $(".select2_demo_3").select2({
            placeholder: "Pilih Kabupaten / Kota Anda",
            allowClear: true
        });
    </script>
</body>

</html>
