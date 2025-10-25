<?php
require_once('../Connections/koneksi.php'); // Pastikan $koneksi aktif (mysqli)

// === Fungsi bantu untuk generate kode otomatis ===
function generateKode($koneksi, $table, $field, $prefix) {
    $result = $koneksi->query("SELECT $field FROM $table ORDER BY $field DESC LIMIT 1");
    $kode = 1;

    if ($result && $row = $result->fetch_assoc()) {
        $lastKode = $row[$field];
        $angka = (int)substr($lastKode, 1);
        $kode = $angka + 1;
    }

    return $prefix . str_pad($kode, 3, "0", STR_PAD_LEFT);
}

// === Proses Tambah Data ===
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Ambil input dari form
    $kd_dokter = $_POST['kd_dokter'];
    $id_jadwal = $_POST['id_jadwal'];
    $nm_dokter = $_POST['nm_dokter'];
    $nip_dokter = $_POST['nip_dokter'];
    $spesialis  = $_POST['spesialis'];
    $kd_poli    = $_POST['kd_poli'];
    $no_hp      = $_POST['no_hp'];
    $hari       = $_POST['hari'];
    $jam_awal   = $_POST['jam_awal'];
    $jam_akhir  = $_POST['jam_akhir'];

    // Simpan ke tabel dokter
    $stmt1 = $koneksi->prepare("INSERT INTO dokter (kd_dokter, nm_dokter, nip_dokter, spesialis, kd_poli, no_hp) 
                                VALUES (?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssss", $kd_dokter, $nm_dokter, $nip_dokter, $spesialis, $kd_poli, $no_hp);
    $ok1 = $stmt1->execute();

    // Simpan ke tabel jadwal dokter
    $stmt2 = $koneksi->prepare("INSERT INTO jdwl_dokter (id_jadwal, kd_dokter, spesialis, hari, jam_awal, jam_akhir) 
                                VALUES (?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssssss", $id_jadwal, $kd_dokter, $spesialis, $hari, $jam_awal, $jam_akhir);
    $ok2 = $stmt2->execute();

    if ($ok1 && $ok2) {
        echo "<script>alert('Data dokter berhasil ditambahkan!'); window.location='?page=data_dokter';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
}

// === Generate kode otomatis ===
$kode_dokter = generateKode($koneksi, 'dokter', 'kd_dokter', 'D');
$kode_jadwal = generateKode($koneksi, 'jdwl_dokter', 'id_jadwal', 'J');
?>

<!-- ===================== FORM TAMBAH DOKTER ===================== -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <table width="100%">
            <tr>
              <td align="left"><h2 class="card-title"><b>Tambah Data Dokter</b></h2></td>
            </tr>
          </table>

          <form method="post" class="mt-4">
            <table class="table table-dark">

              <tr>
                <td align="right">Kode Dokter:</td>
                <td><input type="text" name="kd_dokter" class="form-control" value="<?= $kode_dokter ?>" readonly required></td>
              </tr>

              <tr>
                <td align="right">ID Jadwal:</td>
                <td><input type="text" name="id_jadwal" class="form-control" value="<?= $kode_jadwal ?>" readonly required></td>
              </tr>

              <tr>
                <td align="right">Nama Dokter:</td>
                <td><input type="text" name="nm_dokter" class="form-control" required></td>
              </tr>

              <tr>
                <td align="right">NIP Dokter:</td>
                <td><input type="text" name="nip_dokter" class="form-control" required></td>
              </tr>

              <tr>
                <td align="right">Spesialis:</td>
                <td><input type="text" name="spesialis" class="form-control" required></td>
              </tr>

              <tr>
                <td align="right">Nama Poli:</td>
                <td>
                  <select name="kd_poli" class="form-control" required>
                    <option value="">Pilih Nama Poli</option>
                    <?php
                    $poliResult = $koneksi->query("SELECT * FROM poli");
                    while ($row = $poliResult->fetch_assoc()) {
                        echo "<option value='{$row['kd_poli']}'>{$row['kd_poli']} - {$row['nm_poli']}</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td align="right">No. HP Dokter:</td>
                <td><input type="text" name="no_hp" class="form-control" required></td>
              </tr>

              <tr>
                <td align="right">Hari Praktik:</td>
                <td>
                  <select name="hari" class="form-control" required>
                    <option value="">Pilih Hari Praktik</option>
                    <?php
                    $hariList = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
                    foreach ($hariList as $h) echo "<option value='$h'>$h</option>";
                    ?>
                  </select>
                </td>
              </tr>

              <tr>
                <td align="right">Jam Mulai Praktik:</td>
                <td><input type="time" name="jam_awal" class="form-control" required></td>
              </tr>

              <tr>
                <td align="right">Jam Selesai Praktik:</td>
                <td><input type="time" name="jam_akhir" class="form-control" required></td>
              </tr>

              <tr>
                <td></td>
                <td><input type="submit" value="Tambah Dokter" class="btn btn-primary btn-sm btn-block"></td>
              </tr>
            </table>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
