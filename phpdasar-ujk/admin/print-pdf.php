<?php
require_once '../function/function.php';
require_once '../assets/vendor/autoload.php';
$id = $_GET['print'];
$selectPrint = "SELECT siswa.*, jurusan.* FROM siswa JOIN jurusan ON siswa.id_jurusan = jurusan.id WHERE siswa.id = :id";
$stmt = $db->prepare($selectPrint);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$mpdf = new \Mpdf\Mpdf();
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial;
        }

        table {
            width:100%;
            border-collapse: collapse;
            margin-bottom:20px;
            text-align: left;
        }

        table th,
        table td {
            border: 1px solid #ccc;
        }

        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <?php
    if ($row) {
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>No.</th>";
        echo "<th>NIK.</th>";
        echo "<th>Nama</th>";
        echo "<th>Email</th>";
        echo "<th>Jurusan</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

    $counter =1;
    do {
        echo '<tr>';
        echo '<td>' .$counter . '</td>';
        echo '<td>' .$row['nik'] . '</td>';
        echo '<td>' .$row['nama'] . '</td>';
        echo '<td>' .$row['email'] . '</td>';
        echo '<td>' .$row['name'] . '</td>';
        echo '</tr>';

        $counter++;
    } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    echo "</tbody>";
    echo "</table>";
}
    ?>
    <?php
    $html = ob_get_clean();
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    ?>
</body>

</html>