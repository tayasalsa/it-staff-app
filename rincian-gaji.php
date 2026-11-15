<?php
// Pastikan halaman dibuka melalui pengiriman form POST.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form-karyawan.php");
    exit;
}

// Ambil data dari form.
$nama = trim($_POST["nama"] ?? "");
$nik = trim($_POST["nik"] ?? "");
$jabatan = $_POST["jabatan"] ?? "";
$masaKerja = filter_var($_POST["masaKerja"] ?? null, FILTER_VALIDATE_INT);
$kinerja = filter_var($_POST["kinerja"] ?? null, FILTER_VALIDATE_INT);
$lembur = filter_var($_POST["lembur"] ?? null, FILTER_VALIDATE_INT);
$terlambat = filter_var($_POST["terlambat"] ?? null, FILTER_VALIDATE_INT);

// Validasi seluruh input sebelum perhitungan.
if (
    $nama === "" || $nik === "" ||
    !in_array($jabatan, ["Staff", "Supervisor", "Manager"], true) ||
    $masaKerja === false || $masaKerja === null || $masaKerja < 0 ||
    $kinerja === false || $kinerja === null || !in_array($kinerja, [1, 2, 3], true) ||
    $lembur === false || $lembur === null || $lembur < 0 || $lembur > 300 ||
    $terlambat === false || $terlambat === null || $terlambat < 0 || $terlambat > 31
) {
    http_response_code(422);
    exit("Data tidak valid. Silakan kembali ke form dan periksa semua input.");
}

// Gaji pokok berdasarkan jabatan (switch-case).
switch ($jabatan) {
    case "Staff":
        $gajiPokok = 3000000;
        break;
    case "Supervisor":
        $gajiPokok = 5000000;
        break;
    case "Manager":
        $gajiPokok = 8000000;
        break;
}

// Tunjangan masa kerja.
if ($masaKerja >= 10) {
    $tunjangan = 1500000;
} elseif ($masaKerja >= 5) {
    $tunjangan = 1000000;
} else {
    $tunjangan = 500000;
}

// Uang lembur.
$uangLembur = $lembur * 50000;

// Bonus berdasarkan kategori kinerja pada dropdown.
// A = sangat baik, B = baik, C = perlu peningkatan.
if ($kinerja === 3) {
    $bonus = 1000000;
} elseif ($kinerja === 2) {
    $bonus = 500000;
} else {
    $bonus = 0;
}

$labelKinerja = [
    1 => "C - Perlu peningkatan",
    2 => "B - Baik",
    3 => "A - Sangat baik",
][$kinerja];

// Potongan keterlambatan: 3 hari pertama bebas potongan.
if ($terlambat > 3) {
    $potongan = ($terlambat - 3) * 100000;
} else {
    $potongan = 0;
}

// Total gaji bersih.
$gajiBersih = ($gajiPokok + $tunjangan + $uangLembur + $bonus) - $potongan;

// Fungsi format rupiah dan pengamanan output HTML.
function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ",", ".");
}
function aman($teks) {
    return htmlspecialchars((string) $teks, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Gaji - PT SENTOSA</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f6f7ff;
            color: #171f78;
            min-height: 100vh;
        }

        /* HEADER */
        .header {
            width: 100%;
            min-height: 84px;
            padding: 15px 30px;
            background: linear-gradient(110deg, #59479e, #7564b8);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-icon {
            font-size: 42px;
        }

        .brand h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .brand p {
            font-size: 14px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 13px;
        }

        .separator {
            height: 30px;
            border-left: 1px solid #ffffff66;
        }

        /* LAYOUT UTAMA */
        .container {
            width: calc(100% - 40px);
            max-width: 1440px;
            margin: 28px auto;
        }

        .card {
            width: 100%;
            background: white;
            border: 1px solid #e0e3ff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(60, 50, 120, 0.07);
        }

        /* JUDUL RINCIAN GAJI */
        .card-header {
            min-height: 88px;
            padding: 15px 20px;
            background: linear-gradient(110deg, #f0efff, #f8f7ff);
            display: flex;
            align-items: center;
            gap: 18px;
            border-bottom: 1px solid #eceeff;
        }

        .title-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4c3b99, #715bc0);
            color: white;
            font-size: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .card-header h2 {
            font-size: 23px;
            margin-bottom: 5px;
        }

        .card-header p {
            font-size: 14px;
            color: #5969ad;
            line-height: 1.5;
        }

        /* ISI KARTU */
        .card-body {
            padding: 22px 20px 28px;
        }

        /* INFORMASI KARYAWAN */
        .employee-info {
            width: 100%;
            padding: 22px;
            background: #ffffff;
            border: 1px solid #e5e3f4;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .employee-info-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 16px;
            margin-bottom: 18px;
            border-bottom: 1px solid #eeedf6;
        }

        .employee-info-heading .heading-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #f0edff;
            color: #684fc0;
            font-size: 20px;
        }

        .employee-info-heading h3 {
            color: #30275f;
            font-size: 16px;
            margin-bottom: 3px;
        }

        .employee-info-heading p {
            color: #85819e;
            font-size: 12px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .info-item {
            min-height: 82px;
            padding: 14px 15px;
            background: #faf9ff;
            border: 1px solid #eeecf8;
            border-radius: 9px;
        }

        .info-label {
            font-size: 12px;
            color: #85819e;
            margin-bottom: 9px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 650;
            color: #39316f;
            overflow-wrap: anywhere;
            line-height: 1.45;
        }

        .info-item.primary-info {
            background: #f3f0ff;
            border-color: #e6e0ff;
        }

        /* TABEL GAJI */
        .salary-table {
            width: 100%;
            border: 1px solid #dce0ff;
            border-radius: 9px;
            overflow: hidden;
        }

        .table-header {
            min-height: 44px;
            padding: 12px 20px;
            background: #f0efff;
            display: grid;
            grid-template-columns: 1fr 180px;
            align-items: center;
            gap: 15px;
            font-size: 14px;
            font-weight: 700;
        }

        .table-header span:last-child {
            text-align: right;
        }

        .salary-row {
            min-height: 50px;
            padding: 8px 20px;
            display: grid;
            grid-template-columns: 1fr 180px;
            align-items: center;
            gap: 15px;
            border-top: 1px solid #e2e5ff;
            font-size: 14px;
            background: white;
        }

        .salary-name {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 17px;
            flex-shrink: 0;
        }

        .green {
            background: #43b184;
        }

        .blue {
            background: #36a0e2;
        }

        .purple {
            background: #8651d6;
        }

        .orange {
            background: #ffad38;
        }

        .red {
            background: #ed4960;
        }

        .amount {
            text-align: right;
            white-space: nowrap;
        }

        /* TOTAL GAJI BERSIH */
        .total-salary {
            width: 100%;
            min-height: 75px;
            padding: 15px 20px;
            margin-top: 8px;
            background: linear-gradient(110deg, #f0efff, #eae7ff);
            border-radius: 9px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            color: #6842d0;
        }

        .total-title {
            font-size: 20px;
            font-weight: 750;
        }

        .total-amount {
            font-size: 30px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* TOMBOL KEMBALI */
        .btn-back {
            width: 100%;
            min-height: 55px;
            margin-top: 20px;
            background: white;
            color: #673bd2;
            border: 1px solid #8d6cff;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-back:hover {
            background: #f5f1ff;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
                flex-wrap: wrap;
            }

            .header-right {
                flex-wrap: wrap;
                gap: 10px;
            }

            .container {
                width: calc(100% - 24px);
                margin: 15px auto;
            }

            .info-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .table-header,
            .salary-row {
                grid-template-columns: 1fr 125px;
                padding-left: 12px;
                padding-right: 12px;
                gap: 8px;
            }

            .salary-name {
                gap: 8px;
            }

            .total-title {
                font-size: 17px;
            }

            .total-amount {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .brand-icon {
                font-size: 32px;
            }

            .brand h1 {
                font-size: 18px;
            }

            .brand p {
                font-size: 12px;
            }

            .card-header {
                padding: 14px;
                gap: 12px;
            }

            .title-icon {
                width: 48px;
                height: 48px;
                font-size: 25px;
            }

            .card-header h2 {
                font-size: 19px;
            }

            .card-header p {
                font-size: 12px;
            }

            .card-body {
                padding: 15px 12px 20px;
            }

            .employee-info {
                padding: 15px 12px;
            }

            .info-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .info-item {
                min-height: 74px;
                padding: 11px 10px;
            }

            .info-label {
                font-size: 11px;
            }

            .info-value {
                font-size: 12px;
            }

            .table-header,
            .salary-row {
                grid-template-columns: minmax(0, 1fr) auto;
                padding: 10px 8px;
                font-size: 11px;
                gap: 5px;
            }

            .badge {
                width: 25px;
                height: 25px;
                font-size: 13px;
            }

            .salary-name {
                gap: 6px;
            }

            .total-salary {
                padding: 14px 10px;
            }

            .total-title {
                font-size: 14px;
            }

            .total-amount {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="header">
        <div class="brand">
            <div class="brand-icon">▦</div>

            <div>
                <h1>PT SENTOSA</h1>
                <p>Sistem Penggajian Karyawan</p>
            </div>
        </div>

        <div class="header-right">
            <span>▦ &nbsp; <?= date("l, d F Y") ?></span>
            <div class="separator"></div>
            <span>◉ &nbsp; Admin ⌄</span>
        </div>
    </header>


    <!-- LAYOUT RINCIAN GAJI -->
    <main class="container">

        <section class="card">

            <!-- JUDUL -->
            <div class="card-header">
                <div class="title-icon">💰</div>

                <div>
                    <h2>Rincian Gaji</h2>
                    <p>
                        Hasil perhitungan gaji karyawan berdasarkan
                        aturan yang berlaku.
                    </p>
                </div>
            </div>


            <div class="card-body">

                <!-- INFORMASI YANG DIINPUT DARI FORM -->
                <section class="employee-info">
                    <div class="employee-info-heading">
                        <span class="heading-icon">♙</span>
                        <div>
                            <h3>Data Karyawan</h3>
                            <p>Informasi berdasarkan data yang dimasukkan pada form</p>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item primary-info">
                            <p class="info-label">Nama Karyawan</p>
                            <p class="info-value" id="nama"><?= aman($nama) ?></p>
                        </div>

                        <div class="info-item">
                            <p class="info-label">NIK</p>
                            <p class="info-value" id="nik"><?= aman($nik) ?></p>
                        </div>

                        <div class="info-item">
                            <p class="info-label">Jabatan</p>
                            <p class="info-value" id="jabatan"><?= aman($jabatan) ?></p>
                        </div>

                        <div class="info-item">
                            <p class="info-label">Masa Kerja</p>
                            <p class="info-value" id="masaKerja"><?= aman($masaKerja) ?> Tahun</p>
                        </div>

                        <div class="info-item">
                            <p class="info-label">Nilai Kinerja</p>
                            <p class="info-value" id="kinerja"><?= aman($labelKinerja) ?></p>
                        </div>

                        <div class="info-item">
                            <p class="info-label">Jam Lembur</p>
                            <p class="info-value" id="lembur"><?= aman($lembur) ?> Jam</p>
                        </div>

                        <div class="info-item">
                            <p class="info-label">Hari Terlambat</p>
                            <p class="info-value" id="terlambat"><?= aman($terlambat) ?> Hari</p>
                        </div>
                    </div>
                </section>


                <!-- TABEL KOMPONEN GAJI -->
                <section class="salary-table">

                    <div class="table-header">
                        <span>Komponen</span>
                        <span>Nominal</span>
                    </div>


                    <div class="salary-row">
                        <div class="salary-name">
                            <span class="badge green">▣</span>
                            <span>Gaji Pokok</span>
                        </div>

                        <span class="amount" id="gajiPokok"><?= rupiah($gajiPokok) ?></span>
                    </div>


                    <div class="salary-row">
                        <div class="salary-name">
                            <span class="badge blue">⬡</span>
                            <span>Tunjangan Masa Kerja</span>
                        </div>

                        <span class="amount" id="tunjangan"><?= rupiah($tunjangan) ?></span>
                    </div>


                    <div class="salary-row">
                        <div class="salary-name">
                            <span class="badge purple">◷</span>
                            <span>Uang Lembur</span>
                        </div>

                        <span class="amount" id="uangLembur"><?= rupiah($uangLembur) ?></span>
                    </div>


                    <div class="salary-row">
                        <div class="salary-name">
                            <span class="badge orange">★</span>
                            <span>Bonus Kinerja</span>
                        </div>

                        <span class="amount" id="bonus"><?= rupiah($bonus) ?></span>
                    </div>


                    <div class="salary-row">
                        <div class="salary-name">
                            <span class="badge red">−</span>
                            <span>Potongan Terlambat</span>
                        </div>

                        <span class="amount" id="potongan"><?= rupiah($potongan) ?></span>
                    </div>

                </section>


                <!-- TOTAL GAJI BERSIH -->
                <section class="total-salary">
                    <span class="total-title">
                        💰 &nbsp; Gaji Bersih
                    </span>

                    <strong class="total-amount" id="gajiBersih"><?= rupiah($gajiBersih) ?></strong>
                </section>


                <!-- TOMBOL KEMBALI -->
                <button class="btn-back" onclick="window.location.href='form-karyawan.php'">
                    ‹ &nbsp; Kembali ke Form Karyawan
                </button>

            </div>
        </section>

    </main>

</body>
</html>
