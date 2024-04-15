<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>SearchBook</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa; 
        }
        .title {
            text-align: center; 
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>
    <main role="main">
        <div class="container mt-5">
            <div class="title">
                <h1>School Search Engine</h1>
            </div>
            <form action="#" method="GET" onsubmit="return false" id="searchForm">
                <div class="row">
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="Search for schools in East Java" name="q" id="cari" required>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" name="rank" id="rank" required>
                            <option value="">Tampilkan berapa banyak data</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                    <!-- <div class="col-sm-2">
                        <select class="form-control" name="bentuk" id="bentuk">
                            <option value="">Pilih Bentuk</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SLB">SLB</option>
                            <option value="SMA">SMA</option>
                        </select>
                    </div> -->
                </div>
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <select class="form-control" name="place" id="place">
                            <option value="">Pilih Kota</option>
                            <option value="Kab. Gresik">Kab. Gresik</option>
                            <option value="Kab. Sidoarjo">Kab. Sidoarjo</option>
                            <option value="Kab. Mojokerto">Kab. Mojokerto</option>
                            <option value="Kab. Jombang">Kab. Jombang</option>
                            <option value="Kab. Bojonegoro">Kab. Bojonegoro</option>
                            <option value="Kab. Tuban">Kab. Tuban</option>
                            <option value="Kab. Lamongan">Kab. Lamongan</option>
                            <option value="Kab. Madiun">Kab. Madiun</option>
                            <option value="Kab. Ngawi">Kab. Ngawi</option>
                            <option value="Kab. Magetan">Kab. Magetan</option>
                            <option value="Kab. Ponorogo">Kab. Ponorogo</option>
                            <option value="Kab. Pacitan">Kab. Pacitan</option>
                            <option value="Kab. Kediri">Kab. Kediri</option>
                            <option value="Kab. Nganjuk">Kab. Nganjuk</option>
                            <option value="Kab. Blitar">Kab. Blitar</option>
                            <option value="Kab. Tulungagung">Kab. Tulungagung</option>
                            <option value="Kab. Trenggalek">Kab. Trenggalek</option>
                            <option value="Kab. Malang">Kab. Malang</option>
                            <option value="Kab. Pasuruan">Kab. Pasuruan</option>
                            <option value="Kab. Probolinggo">Kab. Probolinggo</option>
                            <option value="Kab. Lumajang">Kab. Lumajang</option>
                            <option value="Kab. Bondowoso">Kab. Bondowoso</option>
                            <option value="Kab. Situbondo">Kab. Situbondo</option>
                            <option value="Kab. Jember">Kab. Jember</option>
                            <option value="Kab. Banyuwangi">Kab. Banyuwangi</option>
                            <option value="Kab. Pamekasan">Kab. Pamekasan</option>
                            <option value="Kab. Sampang">Kab. Sampang</option>
                            <option value="Kab. Sumenep">Kab. Sumenep</option>
                            <option value="Kab. Bangkalan">Kab. Bangkalan</option>
                            <option value="Kota Surabaya">Kota Surabaya</option>
                            <option value="Kota Malang">Kota Malang</option>
                            <option value="Kota Madiun">Kota Madiun</option>
                            <option value="Kota Kediri">Kota Kediri</option>
                            <option value="Kota Mojokerto">Kota Mojokerto</option>
                            <option value="Kota Blitar">Kota Blitar</option>
                            <option value="Kota Pasuruan">Kota Pasuruan</option>
                            <option value="Kota Probolinggo">Kota Probolinggo</option>
                            <option value="Kota Batu">Kota Batu</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" name="kecamatan" id="kecamatan">
                            <option value="">Pilih Kecamatan</option>
                            @if (!empty($kecamatanByCity))
                                @foreach ($kecamatanByCity as $kabupatenKota => $kecamatans)
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan }}">{{ $kecamatan }}</option>
                                    @endforeach
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm">
                        <button class="btn btn-primary btn-block" id="search">Lakukan Pencarian</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <div class="container mt-5">
        <div class="row" id="content">
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#place").change(function() {
                var selectedCity = $(this).val();
                $.ajax({
                    url: '/get-kecamatan',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        city: selectedCity
                    },
                    success: function(data) {
                        $('#kecamatan').empty();
                        $('#kecamatan').append('<option value="">Pilih Kecamatan</option>');
                        $.each(data, function(index, value) {
                            $('#kecamatan').append('<option value="' + value + '">' + value + '</option>');
                        });
                    },
                    error: function(data) {
                        alert("Gagal memuat daftar kecamatan.");
                    }
                });
            });


            $("#search").click(function() {
                var cari = $("#cari").val();
                var rank = $("#rank").val();
                var place = $("#place").val();
                var kecamatan = $("#kecamatan").val();
                // var bentuk = $("#bentuk").val();
                $.ajax({
                    url: '/search',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: cari,
                        rank: rank,
                        place: place,
                        kecamatan: kecamatan,
                        // bentuk: bentuk
                    },
                    success: function(response) {
                        var data = response;
                        var searchResults = $('#content');
                        searchResults.empty();
                        console.log(data); 
                        if (data != null) {
                            $.each(data, function(index, sekolah) {
                                var status = (sekolah.status == "N") ? "Negeri" : "Swasta";
                                var html = '<div class="col-lg-4 mb-4">' +
                                    '<div class="card border-0" style="background-color: #393838; color: white; border-radius: 10px;">' +
                                    '<div class="card-body">' +
                                    '<h5 class="card-title mb-3"><b>' + sekolah.sekolah + '</b></h5>' +
                                    '<p class="card-text text-white">Lokasi : ' + sekolah.alamat_jalan + '</p>' +
                                    '<p class="card-text mb-2">Kota : ' + sekolah.kabupaten_kota + '</p>' +
                                    '<p class="card-text mb-2">Kecamatan : ' + sekolah.kecamatan + '</p>' +
                                    '<p class="card-text mb-2">Npsn : ' + sekolah.npsn + '</p>' +
                                    '<p class="card-text mb-2">Status : ' + status + '</p>' +
                                    '<p class="card-text mb-0">Koordinat : ' + sekolah.lintang + ',' + sekolah.bujur + '</p>' +
                                    '</div></div></div>';
                                searchResults.append(html);
                            });
                        } else {
                            searchResults.html('<p class="text-muted">Tidak ada hasil pencarian.</p>'); 
                        }
                    },
                    error: function(data) {
                        alert("Gagal melakukan pencarian.");
                        window.location.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>
