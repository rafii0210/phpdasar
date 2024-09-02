<?php
require_once "connect.php";

function query($query)
{
    global $db;
    try {
        $statement = $db->query($query);
        return $statement->fetchAll();
    } catch (PDOException $e) {
        die("Query tidak berhasil: " . $e->getMessage());
    }
}

function upload($destinationDir)
{
    //pastikan direktiri target ada
    if (!is_dir($destinationDir)) {
        mkdir($destinationDir, 0777, true);
    }
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        return false;  // Tidak ada file yang diupload
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $extensiGambar = explode('.', $namaFile);
    $extensiGambar = strtolower(end($extensiGambar));

    if (!in_array($extensiGambar, $ekstensiGambarValid)) {
        return false;
    }

    if ($ukuranFile > 2500000) {
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.' . $extensiGambar;

    if (move_uploaded_file($tmpName, $destinationDir . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        return false;
    }
}

function uploadFile($destinationDir)
{
    // Pastikan direktori target ada
    if (!is_dir($destinationDir)) {
        mkdir($destinationDir, 0777, true);
    }

    $namaFile = $_FILES['file']['name'];
    $ukuranFile = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $tmpName = $_FILES['file']['tmp_name'];

    if ($error === 4) {
        return false;  // Tidak ada file yang diupload
    }

    $ekstensiFileValid = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
    $extensiFile = explode('.', $namaFile);
    $extensiFile = strtolower(end($extensiFile));

    if (!in_array($extensiFile, $ekstensiFileValid)) {
        return false;
    }

    if ($ukuranFile > 10000000) { // Batas ukuran file 10MB
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.' . $extensiFile;

    if (move_uploaded_file($tmpName, $destinationDir . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        return false;
    }
}

//method insert registrasi-akun
function tambahSiswa($data)
{
    global $db;

    $nik = htmlspecialchars($data["nik"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);

    $gambar = upload('../assets/imgSiswa/');

    $siswa = htmlspecialchars($data["siswa"]);
    $password = htmlspecialchars($data["password"]);

    $hash = password_hash($password, PASSWORD_BCRYPT);
    if (!$gambar) {
        return false;
    }

    if (empty($_FILES['file']['name'])) {
        $query = "INSERT INTO siswa (nama,nik,email,id_jurusan,gambar,password,is_status,created_at) VALUES (?,?,?,?,?,?,0,NOW())";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $nama);
        $statement->bindParam(2, $nik);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $siswa);
        $statement->bindParam(5, $gambar);
        $statement->bindParam(6, $hash);
        $statement->execute();

        // Query untuk mendapatkan id instruktur berdasarkan email
        $select = "SELECT id FROM siswa WHERE email = :email";
        $statementSelect = $db->prepare($select);
        $statementSelect->bindValue(':email', $email, PDO::PARAM_STR);
        $statementSelect->execute();
        $row = $statementSelect->fetch(PDO::FETCH_ASSOC);

        // Periksa apakah ada hasil yang ditemukan
        if ($row) {
            $id = $row['id'];
            // Lakukan sesuatu dengan $id
        } else {
            // Tidak ada hasil ditemukan, tangani sesuai kebutuhan
            echo "Siswa dengan email tersebut tidak ditemukan.";
        }
    } else {
        $file = uploadFile('../assets/filesSiswa/');
        if (!$file) {
            return false;
        }
        $query = "INSERT INTO siswa (nama,nik,email,id_jurusan,gambar,files,password,is_status,created_at) VALUES (?,?,?,?,?,?,?,0,NOW())";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $nama);
        $statement->bindParam(2, $nik);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $siswa);
        $statement->bindParam(5, $gambar);
        $statement->bindParam(6, $file);
        $statement->bindParam(7, $hash);
        $statement->execute();

        // Query untuk mendapatkan id instruktur berdasarkan email
        $select = "SELECT id FROM siswa WHERE email = :email";
        $statementSelect = $db->prepare($select);
        $statementSelect->bindValue(':email', $email, PDO::PARAM_STR);
        $statementSelect->execute();
        $row = $statementSelect->fetch(PDO::FETCH_ASSOC);

        // Periksa apakah ada hasil yang ditemukan
        if ($row) {
            $id = $row['id'];
            // Lakukan sesuatu dengan $id
        } else {
            // Tidak ada hasil ditemukan, tangani sesuai kebutuhan
            echo "Siswa dengan email tersebut tidak ditemukan.";
        }
    }
    return $statement->rowCount();
}

function hapusSiswa($id)
{
    global $db;

    $query_select = "SELECT gambar, files FROM siswa WHERE id = ?";
    $statement_select = $db->prepare($query_select);
    $statement_select->bindParam(1, $id);
    $statement_select->execute();
    $object = $statement_select->fetch(PDO::FETCH_ASSOC);

    $query_delete = "DELETE FROM siswa WHERE id = ?";
    $statement_delete = $db->prepare($query_delete);
    $statement_delete->bindParam(1, $id);
    $statement_delete->execute();

    if ($statement_delete->rowCount() > 0) {
        $file_path = "../../../assets/imgSiswa/" . $object['gambar'];
        $file_pathfILE = "../../../assets/filesSiswa/" . $object['files'];

        if (file_exists($file_path)) {
            unlink($file_path);
        }
        if (file_exists($file_pathfILE)) {
            unlink($file_pathfILE);
        }
    }
    return $statement_delete->rowCount();
}
