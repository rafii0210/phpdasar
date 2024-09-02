<!-- 1.a insert. buat dulu table siswa, jurusan. kemudian panggil method tambahSiswa() -->
<?php
if (isset($_POST['submit'])) {
  if (tambahSiswa($_POST) > 0) {
    echo "<script>
    alert('data berhasil ditambah');
    document.location.href = 'index.php?page=rgs&statAdd=successAdd';
  </script>";
  } else {
    echo "<script>
  alert('data gagal ditambah');
  document.location.href = 'index.php?page=rgs';
</script>";
  }
}
?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label fw-bold" for="nik">NIK :</label>
            <input class="form-control" type="text" id="nik" name="nik" required>
          </div>
          <div class="mb-3">
            <label for="nama" class="form-label fw-bold">Nama :</label>
            <input class="form-control" type="text" id="nama" name="nama" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email :</label>
            <input type="email" id="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="siswa" class="form-label fw-bold">Jurusan :</label>
            <select class="form-control" name="siswa" required>
              <option value="">----</option>
              <option value="1">Junior Web Programming</option>
              <option value="2">Jaringan Komputer</option>
              <option value="3">Bahasa Inggris</option>
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
            <label for="gambar" class="form-label fw-bold">Gambar :</label>
            <input type="file" id="gambar" name="gambar" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="file" class="form-label fw-bold">File Ijazah :</label>
            <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="submit">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#togglePassword').click(function() {
      const passwordField = $('#password');
      const passwordFieldType = passwordField.attr('type');
      const eyeIcon = $('#eyeIcon');

      if (passwordFieldType === 'password') {
        passwordField.attr('type', 'text');
        eyeIcon.removeClass('fa-eye');
        eyeIcon.addClass('fa-eye-slash');
      } else {
        passwordField.attr('type', 'password');
        eyeIcon.removeClass('fa-eye-slash');
        eyeIcon.addClass('fa-eye');
      }
    });
  });
</script>