<?php
require_once '../../../function/function.php';

// Mendapatkan nilai pencarian dari permintaan AJAX
$searchTerm = htmlspecialchars($_POST['searchTerm']);

// Lakukan pencarian di tabel pertama
$query1 = "SELECT * FROM siswa WHERE nama LIKE '%$searchTerm%'";
$stmt = $db->prepare($query1);
$stmt->execute();

// Lakukan pencarian di tabel kedua
$query2 = "SELECT * FROM jurusan WHERE name LIKE '%$searchTerm%'";
$stmt2 = $db->prepare($query2);
$stmt2->execute();


if (!empty($searchTerm)) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<h2>Hasil Pencarian di Tabel 1</h2>';
        echo $row['nama'] . ' <input type="radio" name="status" value="1">Lolos <input type="radio" name="status" value="1"> Tidak Lolos' . '<br>';
    }

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo '<h2>Hasil Pencarian di Tabel 2</h2>';
        echo $row['name'] . '<br>';
    }
}

// Tutup koneksi database
$stmt->closeCursor();
$stmt2->closeCursor();
