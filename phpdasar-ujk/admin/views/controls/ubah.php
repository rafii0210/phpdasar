<?php
require_once "../../../function/function.php";
if (isset($_POST['idtag'])) {
  $id = htmlspecialchars($_POST['idtag']);

  $statement = $db->prepare('SELECT * FROM siswa WHERE id = ?');
  $statement->bindParam(1, $id);
  $statement->execute();
  $siswa = $statement->fetch(PDO::FETCH_ASSOC);
} else {
  echo "<script>
  alert('ID tidak ditemukan');
  document.location.href = 'pendaftaran.php';
  </script>";
}

?>
<!-- Modal -->
<div class="modal-header">
  <div class="modal-title">
    <h3>Data Peserta Ubah</h3>
  </div>
</div>
<div class="modal-body">
  <div class="container">
    <div class="row">
      <div class="col-10">
        <form id="updateForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="isStatus" class="form-label fw-bold">Status Akun :</label><br>
            <pre class="h5 fw-bold text-primary">Active     : <input type="radio" name="isStatus" value="1" class="form-group" <?= ($siswa['is_status'] == 1) ? 'checked' : '' ?>></pre>
            <pre class="h5 fw-bold text-warning">Non-Active : <input type="radio" name="isStatus" value="0" class="form-group" <?= ($siswa['is_status'] == 0) ? 'checked' : '' ?>></pre>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold" for="nik">NIK :</label>
            <input type="hidden" class="form-control" id="gambarLama_" name="gambarLama" value="<?= htmlspecialchars($siswa["gambar"]) ?>">
            <input type="hidden" class="form-control" id="fileLama_" name="fileLama" value="<?= htmlspecialchars($siswa["files"]) ?>">
            <input class="form-control" type="text" id="nik_" name="nik" value="<?= htmlspecialchars($siswa["nik"]); ?>" required>
          </div>
          <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Nama :</label>
            <input class="form-control" type="text" id="nama_" name="nama" value="<?= htmlspecialchars($siswa["nama"]); ?>" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email :</label>
            <input type="email" id="email_" name="email" class="form-control" value="<?= htmlspecialchars($siswa["email"]); ?>" required>
          </div>
          <div class="mb-3">
            <label for="jurusan" class="form-label fw-bold">Jurusan :</label>
            <select class="form-control" name="jurusan" required>
              <option value="">----</option>
              <option value="1" <?= ($siswa['id_jurusan'] == 1) ? 'selected' : '' ?>>Junior Web Programming</option>
              <option value="2" <?= ($siswa['id_jurusan'] == 2) ? 'selected' : '' ?>>Jaringan Komputer</option>
              <option value="3" <?= ($siswa['id_jurusan'] == 3) ? 'selected' : '' ?>>Bahasa Inggris</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password :</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                  <i class="fa fa-eye" id="eyeIcon"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="gambar" class="form-label fw-bold">Gambar :</label><br>
            <img src="../assets/imgSiswa/<?= htmlspecialchars($siswa["gambar"]) ?>" alt="" width="100" height="100"><br>
            <input type="file" id="gambar_" name="gambar" class="form-control mt-1" value="<?= htmlspecialchars($siswa["gambar"]); ?>">
          </div>
          <div class="mb-3">
            <label for="fileEdit" class="form-label fw-bold">Files :</label><br>
            <a href="../assets/filesSiswa/<?= htmlspecialchars($siswa["files"]) ?>" target="_blank"><?= htmlspecialchars($siswa["files"]) ?></a><br><br>
            <input type="file" class="form-control" id="file_" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" value="<?= htmlspecialchars($siswa["files"]); ?>">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_cancel">Close</button>
        <button type="submit" class="btn btn-primary" name="submitEdit" onclick="updateData()">Save</button> <!-- Ganti type menjadi button dan tambahkan onclick untuk memanggil fungsi updateData() -->
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<script>
  function updateData() {
    var form = document.getElementById('updateForm');
    var formData = new FormData(form);
    formData.append('id', <?= json_encode($siswa['id']) ?>);
    fetch('views/controls/ubahquery.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        try {
          var jsonData = JSON.parse(data);
          console.log(jsonData);
          if (jsonData.status === "success") {
            console.log('update berhasil');
            window.location.href = 'index.php?page=rgs&status=success';
          } else {
            alert("Terjadi Kesalahan Pengiriman Data");
            console.error('Error', jsonData.message);
          }
        } catch (e) {
          console.log('Parse error:', e);
        }
      })
      .catch(error => {
        console.error('Fetch Error', error);
      });
  }
</script>