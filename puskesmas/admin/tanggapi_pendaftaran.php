<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';
require_once '../includes/functions.php';

$id_pasien = isset($_GET['id_pasien']) ? $_GET['id_pasien'] : null;
if (!$id_pasien) die("ID Pasien tidak ditemukan.");

try {
    // Ambil data pasien
    $stmt = $pdo->prepare("SELECT * FROM pasien WHERE id_pasien = ?");
    $stmt->execute([$id_pasien]);
    $pasien = $stmt->fetch();
    if (!$pasien) die("Data pasien tidak ditemukan.");

    // Ambil daftar poli
    $polis = $pdo->query("SELECT kd_poli, nm_poli FROM poli ORDER BY nm_poli ASC")->fetchAll();
} catch (PDOException $e) {
    die("Kesalahan: " . $e->getMessage());
}

// Proses submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pasien = sanitize($_POST['id_pasien']);
    $kd_poli = sanitize($_POST['kd_poli']);
    $kd_dokter = sanitize($_POST['kd_dokter']);
    $nm_pasien = sanitize($_POST['nm_pasien']);
    $nm_dokter = sanitize($_POST['nm_dokter']);
    $tgl_berobat = sanitize($_POST['tgl_berobat']);
    $keluhan = sanitize($_POST['keluhan']);
    $no_hp = sanitize($_POST['no_hp']);

    try {
        // Insert data ke pendaftaran
        $insert = $pdo->prepare("
        INSERT INTO pendaftaran 
        (id_pasien, kd_poli, kd_dokter, nm_pasien, nm_dokter, tgl_berobat, keluhan, no_hp)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $insert->execute([$id_pasien, $kd_poli, $kd_dokter, $nm_pasien, $nm_dokter, $tgl_berobat, $keluhan, $no_hp]);
                                        
        // Update data pasien
        $update = $pdo->prepare("
            UPDATE pasien SET kd_poli = ?, kd_dokter = ?, nm_dokter = ? WHERE id_pasien = ?
        ");
        $update->execute([$kd_poli, $kd_dokter, $nm_dokter, $id_pasien]);

        redirect('?page=pendaftaran', 'Data berhasil ditambahkan!');
    } catch (PDOException $e) {
        echo "<div style='color:red;'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!-- ============= FORM INPUT PENDAFTARAN ============= -->
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title"><b>Tambah Data Pendaftaran</b></h2>
                    <form method="post" id="form2">
                        <table class="table table-dark">
                            <tr>
                                <td>ID Pasien</td>
                                <td><input type="text" name="id_pasien" value="<?= htmlspecialchars($pasien['id_pasien']) ?>" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Nama Pasien</td>
                                <td><input type="text" name="nm_pasien" value="<?= htmlspecialchars($pasien['nm_pasien']) ?>" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td><input type="text" value="<?= htmlspecialchars($pasien['jenkel']) ?>" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td><textarea class="form-control" readonly><?= htmlspecialchars($pasien['alamat']) ?></textarea></td>
                            </tr>
                            <tr>
                                <td>Nama Poli</td>
                                <td>
                                    <select name="kd_poli" id="kd_poli" required class="form-control">
                                        <option value="">Pilih Poli</option>
                                        <?php foreach ($polis as $p): ?>
                                            <option value="<?= htmlspecialchars($p['kd_poli']) ?>"><?= htmlspecialchars($p['nm_poli']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Dokter</td>
                                <td>
                                <select name="kd_dokter" id="kd_dokter" class="form-control" required>
                                <option value="">Pilih Dokter</option>
                                </select>
                                    <input type="hidden" name="nm_dokter" id="nm_dokter">
                                </td>
                            </tr>                                                                                                                                                                                        </tr>
                                                                                                                                                                                               <tr>
                                <td>Tanggal Berobat</td>
                                <td><input type="date" name="tgl_berobat" id="tgl_berobat" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Keluhan</td>
                                <td><input type="text" name="keluhan" value="<?= htmlspecialchars(isset($pasien['keluhan']) ? $pasien['keluhan'] : '') ?>"
                                 class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>No HP</td>
                                <td><input type="text" name="no_hp" value="<?= htmlspecialchars(isset($pasien['no_hp']) ? $pasien['no_hp'] : '') ?>"
 class="form-control" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button type="submit" class="btn btn-primary">Simpan Data</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============= SCRIPT AJAX ============= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    // Ketika pilih poli
    $('#kd_poli').on('change', function(){
        var kd_poli = $(this).val();
        if (kd_poli) {
            $.get('../includes/get_dokter.php', { kd_poli: kd_poli }, function(data){
                $('#kd_dokter').html(data);
                $('#nm_dokter').val(''); // reset nama dokter
            });
        } else {
            $('#kd_dokter').html('<option value="">Pilih Dokter</option>');
            $('#nm_dokter').val('');
        }
    });

    // Ketika pilih dokter
    $('#kd_dokter').on('change', function(){
        var nm_dokter = $('#kd_dokter option:selected').text();
        $('#nm_dokter').val(nm_dokter);
    });
});
</script>