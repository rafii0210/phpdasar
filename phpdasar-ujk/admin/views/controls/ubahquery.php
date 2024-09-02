<?php
require_once '../../../function/function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = htmlspecialchars($_POST['id']);
    $nik = htmlspecialchars($_POST['nik']);
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $password = htmlspecialchars($_POST['password']);
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $gambarLama = htmlspecialchars($_POST['gambarLama']);
    $fileLama = htmlspecialchars($_POST['fileLama']);
    $gambar = $gambarLama;
    $file = $fileLama;
    $is_status = htmlspecialchars($_POST['isStatus']);

    //Ambil nama gambar dari database sebelum menghapus entry
    $query_select = "SELECT files FROM siswa WHERE id = ?";
    $statement_select = $db->prepare($query_select);
    $statement_select->bindParam(1, $id);
    $statement_select->execute();
    $object = $statement_select->fetch(PDO::FETCH_ASSOC);

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== 4) {
        $gambarBaru = upload('../../../assets/imgSiswa/');
        if (!$gambarBaru) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Gagal Mengupload Gambar"));
            exit;
        }
        //Gambar baru diunggah dengan sukses, hapus gambar lama
        $gambar = $gambarBaru;
        $file_path = '../../../assets/imgSiswa/' . $gambarLama;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    if (isset($_FILES['file']) && $_FILES['file']['error'] !== 4) {
        $fileBaru = uploadFile('../../../assets/filesSiswa/');
        if (!$fileBaru) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Gagal Mengupload file"));
            exit;
        }
        //File baru diunggah dengan sukses, hapus file lama
        $file = $fileBaru;
        $file_pathFile = '../../../assets/filesSiswa/' . $object['files'];
        if (file_exists($file_pathFile)) {
            if (isset($object['files']) == null) {
                $file;
            } else {
                unlink($file_pathFile);
            }
        }
    }

    if (empty($password)) {
        $query = "UPDATE siswa SET nik = ?, nama = ?, email = ?, id_jurusan = ?, gambar = ?, files = ?, is_status = ?, updated_at = now() WHERE id = ?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $nik);
        $statement->bindParam(2, $nama);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $jurusan);
        $statement->bindParam(5, $gambar);
        $statement->bindParam(6, $file);
        $statement->bindParam(7, $is_status);
        $statement->bindParam(8, $id);
    } else {
        $query = "UPDATE siswa SET nik = ?, nama = ?, email = ?, id_jurusan = ?, gambar = ?, files = ?, password = ?, is_status = ?, updated_at = now() WHERE id = ?";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $nik);
        $statement->bindParam(2, $nama);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $jurusan);
        $statement->bindParam(5, $gambar);
        $statement->bindParam(6, $file);
        $statement->bindParam(7, $hash);
        $statement->bindParam(8, $is_status);
        $statement->bindParam(9, $id);
    }
    if ($statement->execute()) {
        echo json_encode(array("status" => "success"));
    } else {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Gagal memperbarui data siswa"));
    }
} else {
    http_response_code(400);
    echo json_encode(array('status' => 'error', 'message' => 'Metode request ada yang salah'));
}
