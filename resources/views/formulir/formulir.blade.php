<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendataan IKM</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('/assets/images/backgrounds/formulir.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;

        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: auto;
            padding: 30px;
            background-color: #f5f5f5;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;

        }

        .container h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
            color: #34495e;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border-radius: 8px;
            border: 2px solid #000000;
            /* Border hitam */
            background-color: #ffffff;
            transition: border-color 0.3s ease, background-color 0.5s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #000000;
            /* Border tetap hitam saat fokus */
            background-color: #fff;
        }

        .form-group textarea {
            resize: vertical;
            height: 100px;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        .form-group button:hover {
            background-color: #2980b9;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .container h1 {
                font-size: 24px;
            }

            .form-row {
                flex-direction: column;
            }
        }

        .form-group input[type="file"] {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Formulir Pendataan IKM</h1>
        @if (session('success'))
        <div style="color: green; text-align: center; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
        @endif
        <form action="{{ route('ikm_data.store') }}" method="POST">
            @csrf
            <!-- Nama Usaha -->
            <div class="form-group">
                <label for="nama_usaha">Nama Usaha</label>
                <input type="text" id="nama_usaha" name="nama_usaha" placeholder="Masukkan Nama Usaha" required>
            </div>

            <!-- NIB -->
            <div class="form-group">
                <label for="nib">NIB</label>
                <input type="text" id="nib" name="nib" placeholder="Masukkan NIB" required>
            </div>

            <!-- Nama Pemilik -->
            <div class="form-group">
                <label for="nama_pemilik">Nama Pemilik</label>
                <input type="text" id="nama_pemilik" name="nama_pemilik" placeholder="Pastikan penulisan sesuai KTP"
                    required>
            </div>

            <!-- No. Whatsapp -->
            <div class="form-group">
                <label for="no_whatsapp">No. Whatsapp</label>
                <input type="tel" id="no_whatsapp" name="no_whatsapp" placeholder="Masukkan No. Whatsapp"
                    pattern="[0-9]{10,15}" inputmode="numeric" required>
            </div>

            <!-- Alamat Pemilik -->
            <div class="form-group">
                <label for="alamat_pemilik">Alamat Pemilik</label>
                <textarea id="alamat_pemilik" name="alamat_pemilik" placeholder="Tulis Alamat Pemilik" required></textarea>
            </div>

            <!-- Alamat Usaha -->
            <div class="form-group">
                <label for="alamat_usaha">Alamat Usaha</label>
                <textarea id="alamat_usaha" name="alamat_usaha" placeholder="Tulis Alamat Usaha" required></textarea>
            </div>

            <!-- Kelurahan -->
            <div class="form-group">
                <label for="kelurahan">Kelurahan</label>
                <select id="kelurahan" name="kelurahan" required>
                    <option value="">Pilih Kelurahan</option>
                    <option value="sekejati">Sekejati</option>
                    <option value="margasari">Margasari</option>
                    <option value="cijawura">Cijawura</option>
                    <option value="jatisari">Jatisari</option>
                </select>
            </div>

            <!-- RW -->
            <div class="form-group">
                <label for="rw">RW</label>
                <input type="text" id="rw" name="rw" placeholder="Masukkan RW" required>
            </div>

            <!-- Kapasitas per bulan and Kapasitas per tahun -->
            <div class="form-row">
                <div class="form-group" style="margin-right: 20px;">
                    <label for="kapasitas_bulan">Kapasitas/bulan</label>
                    <input type="text" id="kapasitas_bulan" name="kapasitas_bulan"
                        placeholder="Masukkan Kapasitas per bulan" required>
                </div>
                <div class="form-group">
                    <label for="kapasitas_tahun">Kapasitas/tahun</label>
                    <input type="text" id="kapasitas_tahun" name="kapasitas_tahun"
                        placeholder="Masukkan Kapasitas per tahun" required>
                </div>
            </div>

            <!-- Halal -->
            <div class="form-group">
                <label for="halal">Halal</label>
                <select id="halal" name="halal" onchange="toggleFileUpload(this)" required>
                    <option value="">Pilih Opsi</option>
                    <option value="ya">YA</option>
                    <option value="tidak">TIDAK</option>
                </select>
                <!-- File upload input yang hanya muncul jika YA -->
                <input type="file" id="file_halal" name="file_halal" style="display: none;" accept=".pdf, .jpg, .png">
            </div>

            <script>
                function toggleFileUpload(select) {
                    const fileInput = document.getElementById('file_halal');
                    if (select.value === 'ya') {
                        fileInput.style.display = 'block'; // Menampilkan input file jika "YA" dipilih
                    } else {
                        fileInput.style.display = 'none'; // Menyembunyikan input file jika "TIDAK" dipilih
                        fileInput.value = ''; // Menghapus file yang mungkin sudah terunggah jika pilihan berubah
                    }
                }
            </script>

            <!-- PIRT -->
            <div class="form-group">
                <label for="pirt">PIRT</label>
                <input type="text" id="pirt" name="pirt" placeholder="Masukkan Informasi PIRT">
                <!-- Tambahkan input untuk unggah file PIRT -->
                <input type="file" id="file_pirt" name="file_pirt" accept=".pdf, .jpg, .png">
            </div>

            <!-- BPOM -->
            <div class="form-group">
                <label for="bpom">BPOM</label>
                <input type="text" id="bpom" name="bpom" placeholder="Masukkan Informasi BPOM">
                <!-- Tambahkan input untuk unggah file BPOM -->
                <input type="file" id="file_bpom" name="file_bpom" accept=".pdf, .jpg, .png">
            </div>

            <!-- Bidang Usaha -->
            <div class="form-group">
                <label for="bidang_usaha">Bidang Usaha</label>
                <input type="text" id="bidang_usaha" name="bidang_usaha" placeholder="Masukkan Bidang Usaha" required>
                <input type="file" id="file_bidang_usaha" name="file_bidang_usaha" accept=".pdf, .doc, .docx, .xls, .xlsx, .csv">
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>