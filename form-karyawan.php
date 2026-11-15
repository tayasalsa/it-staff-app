<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Karyawan - PT SENTOSA</title>

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
            height: 84px;
            padding: 0 30px;
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
            min-height: 830px;
            background: white;
            border: 1px solid #e0e3ff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(60, 50, 120, 0.07);
        }

        /* HEADER FORM */
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

        /* ISI FORM */
        .card-body {
            padding: 28px 20px 35px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 26px;
            row-gap: 40px;
        }

        .field {
            min-width: 0;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .label-icon {
            width: 25px;
            text-align: center;
            font-size: 20px;
        }

        input,
        select {
            width: 100%;
            height: 53px;
            padding: 0 14px;
            border: 1px solid #cbd3ff;
            border-radius: 9px;
            background: white;
            color: #26337e;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: 0.2s;
        }

        input::placeholder {
            color: #8290c8;
        }

        input:focus,
        select:focus {
            border-color: #715bc0;
            box-shadow: 0 0 0 3px #715bc020;
        }

        /* INPUT DENGAN SATUAN */
        .input-group {
            display: flex;
            width: 100%;
        }

        .input-group input {
            flex: 1;
            min-width: 0;
            border-radius: 9px 0 0 9px;
        }

        .unit {
            min-width: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 12px;
            background: #eff0fb;
            border: 1px solid #cbd3ff;
            border-left: none;
            border-radius: 0 9px 9px 0;
            font-size: 13px;
        }

        /* TOMBOL SIMPAN */
        .btn-primary {
            width: 100%;
            height: 53px;
            margin-top: 43px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(100deg, #6852a9, #6551a4);
            color: white;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: #493783;
            transform: translateY(-1px);
        }

        .message {
            margin-top: 12px;
            font-size: 13px;
            line-height: 1.5;
        }

        .message.error {
            color: #c03950;
        }

        .message.success {
            color: #27885e;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .header {
                height: auto;
                min-height: 84px;
                padding: 15px 20px;
                flex-wrap: wrap;
            }

            .header-right {
                flex-wrap: wrap;
                gap: 10px;
            }

            .container {
                width: calc(100% - 24px);
                margin: 18px auto;
            }

            .card {
                min-height: auto;
            }

            .form-grid {
                column-gap: 16px;
                row-gap: 28px;
            }

            .card-body {
                padding: 22px 16px 28px;
            }

            .btn-primary {
                margin-top: 32px;
            }
        }

        @media (max-width: 480px) {
            .brand {
                gap: 10px;
            }

            .brand-icon {
                font-size: 32px;
            }

            .brand h1 {
                font-size: 18px;
            }

            .brand p {
                font-size: 12px;
            }

            .header-right {
                font-size: 11px;
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
                padding: 20px 12px 25px;
            }

            .form-grid {
                column-gap: 12px;
                row-gap: 25px;
            }

            label {
                font-size: 12px;
                gap: 5px;
            }

            .label-icon {
                width: 20px;
                font-size: 16px;
            }

            input,
            select {
                height: 47px;
                padding: 0 8px;
                font-size: 12px;
            }

            .unit {
                min-width: 35px;
                padding: 0 6px;
                font-size: 11px;
            }

            .btn-primary {
                height: 49px;
                margin-top: 30px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER WEBSITE -->
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


    <!-- LAYOUT FORM KARYAWAN -->
    <main class="container">

        <section class="card">

            <!-- JUDUL FORM -->
            <div class="card-header">

                <div class="title-icon">♟</div>

                <div>
                    <h2>Form Karyawan</h2>
                    <p>
                        Masukkan data karyawan untuk menghitung gaji.
                    </p>
                </div>

            </div>


            <!-- FORM INPUT -->
            <div class="card-body">

                <form id="formKaryawan" action="rincian-gaji.php" method="POST">

                    <div class="form-grid">

                        <!-- NAMA -->
                        <div class="field full">

                            <label for="nama">
                                <span class="label-icon">♟</span>
                                Nama Karyawan
                            </label>

                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                placeholder="Masukkan nama karyawan"
                                required
                            >

                        </div>


                        <!-- NIK -->
                        <div class="field">

                            <label for="nik">
                                <span class="label-icon">▣</span>
                                NIK
                            </label>

                            <input
                                type="text"
                                id="nik"
                                name="nik"
                                placeholder="Masukkan NIK"
                                required
                            >

                        </div>


                        <!-- JABATAN -->
                        <div class="field">

                            <label for="jabatan">
                                <span class="label-icon">▣</span>
                                Jabatan
                            </label>

                            <select
                                id="jabatan"
                                name="jabatan"
                                required
                            >
                                <option value="">Pilih jabatan</option>
                                <option value="Manager">Manager</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                            </select>

                        </div>


                        <!-- MASA KERJA -->
                        <div class="field">

                            <label for="masaKerja">
                                <span class="label-icon">▦</span>
                                Masa Kerja (Tahun)
                            </label>

                            <select
                                id="masaKerja"
                                name="masaKerja"
                                required
                            >
                                <option value="">Pilih masa kerja</option>
                                <option value="0">Kurang dari 1 tahun</option>
                                <option value="1">1–2 tahun</option>
                                <option value="3">3–5 tahun</option>
                                <option value="6">6–10 tahun</option>
                                <option value="11">Lebih dari 10 tahun</option>
                            </select>

                        </div>


                        <!-- NILAI KINERJA -->
                        <div class="field">

                            <label for="kinerja">
                                <span class="label-icon">★</span>
                                Nilai Rapor Kinerja
                            </label>

                            <select
                                id="kinerja"
                                name="kinerja"
                                required
                            >
                                <option value="">Pilih nilai kinerja</option>
                                <option value="1">C - Perlu peningkatan</option>
                                <option value="2">B - Baik</option>
                                <option value="3">A - Sangat baik</option>
                            </select>

                        </div>


                        <!-- JAM LEMBUR -->
                        <div class="field">

                            <label for="lembur">
                                <span class="label-icon">◷</span>
                                Jam Lembur
                            </label>

                            <div class="input-group">

                                <input
                                    type="number"
                                    id="lembur"
                                    name="lembur"
                                    min="0"
                                    max="300"
                                    value="0"
                                    placeholder="Masukkan jumlah jam lembur"
                                    required
                                >

                                <span class="unit">jam</span>

                            </div>

                        </div>


                        <!-- HARI TERLAMBAT -->
                        <div class="field">

                            <label for="terlambat">
                                <span class="label-icon">⚠</span>
                                Hari Terlambat
                            </label>

                            <div class="input-group">

                                <input
                                    type="number"
                                    id="terlambat"
                                    name="terlambat"
                                    min="0"
                                    max="31"
                                    value="0"
                                    placeholder="Masukkan jumlah hari terlambat"
                                    required
                                >

                                <span class="unit">hari</span>

                            </div>

                        </div>

                    </div>


                    <!-- TOMBOL SIMPAN -->
                    <button type="submit" class="btn-primary">
                        ▣ &nbsp; Simpan &amp; Cek
                    </button>

                    <p id="message" class="message"></p>

                </form>

            </div>

        </section>

    </main>
</body>
</html>
