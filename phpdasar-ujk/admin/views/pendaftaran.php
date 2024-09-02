<?php
$query = "SELECT * FROM view_siswa";
$result = $db->query($query);
$students = $result->fetchAll(PDO::FETCH_ASSOC);
//  var_dump($students);
?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pendaftaran Siswa Baru!</h1>
    </div>
    <!-- Content Row -->
    <?php
    if (isset($_GET['status']) == "success") {
        echo "    <div class='alert alert-primary' id='myAlert1' role='alert'>
                         Berhasil Di Ubah!
                            </div>";
    }

    if (isset($_GET['statusDel']) == "successDel") {
        echo "    <div class='alert alert-primary' id='myAlert2' role='alert'>
                         Berhasil Di Hapus!
                            </div>";
    }

    if (isset($_GET['statAdd']) == "successAdd") {
        echo "    <div class='alert alert-primary' id='myAlert2' role='alert'>
                         Berhasil Di Tambah!
                            </div>";
    }
    ?>
    <div class="row">
        <div class="col-xl-11 col-md-11">
            <!-- isi content -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD DATA</button>
            <?php
            require_once "controls/tambah.php";
            ?>
            <a type="button" class="btn btn-danger" href="">Print PDF</a>
            <div class="table-responsive mt-3">
                <table class="table table-bordered " id="datatables">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Aksi</th>
                            <th>Gambar</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jurusan</th>
                            <th>File Ijazah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($students as $student) :
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <?php
                                $click_edt = "onclick='btn_edit(" . $student['id'] . ")'";
                                $btn_edt = "<button " . $click_edt . " class='btn btn-success btn-sm ' data-toggle='tooltip' title='Edit'>Ubah</button>";
                                ?>
                                <td><?= $btn_edt ?> <a class="btn btn-danger btn-sm " href='views/controls/hapus.php?vz=<?= base64_encode($student['id']) ?>' onclick="return confirm('Apakah benar ingin di hapus ?')">Hapus</a>
                                <a type="button" class="btn btn-warning btn-sm" href=" print-pdf.php?print=<?php echo $student['id']?>">Print PDF</a>
                                </td>
                                <td><img src="../assets/imgSiswa/<?= $student['gambar'] ?>" alt="" width="70" height="auto"></td>
                                <td><?= $student['nik'] ?></td>
                                <td><?= $student['nama'] ?></td>
                                <td><?= $student['email'] ?></td>
                                <td><?= $student['name'] ?></td>
                                <td><a class="btn btn-primary btn-sm" href="../assets/filesSiswa/<?= $student['files'] ?>" target="_blank">view</a></td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- end content -->
        </div>
    </div>
</div>
<!-- Proses Pencarian -->
<form id="searchForm">
    <input type="text" id="searchTerm" name="searchTerm" placeholder="Masukkan kata kunci">
    <button type="submit">Cari</button>

    <div id="searchResults"></div>
</form>

<!--Modal Edit-->
<div class="modal" data-refresh="true" data-bs-backdrop="static" id="edt" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>

<script>
    function btn_edit(row_id) {
        $("#edt").modal('show').find('.modal-content').load('views/controls/ubah.php', {
            idtag: row_id
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#searchForm').submit(function(event) {
            // Mencegah perilaku default form
            event.preventDefault();

            // Mendapatkan nilai pencarian
            var searchTerm = $('#searchTerm').val();

            // Kirim permintaan AJAX ke backend
            $.ajax({
                url: 'views/controls/proses_pencarian.php', // Ganti dengan URL yang sesuai dengan backend Anda
                method: 'POST',
                data: {
                    searchTerm: searchTerm
                },
                success: function(response) {
                    // Tampilkan hasil pencarian ke dalam elemen dengan ID 'searchResults'
                    $('#searchResults').html(response);
                }
            });
        });
    });
</script>