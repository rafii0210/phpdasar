<?php
require_once '../../../function/function.php';

$id = base64_decode($_GET['vz']);
if (hapusSiswa($id) > 0) {
    echo "<script>
    if(confirm('Data berhasil dihapus!')){
        window.location.href = '../../index.php?page=rgs&statusDel=successDel';
    }else {
        window.location.href = '../../index.php?page=rgs&statusDel=gagalDel';
    }
    </script>";
} else {
    echo "<script>
    if(confirm('Data gagal dihapus!')){
        window.location.href = '../../index.php?page=rgs';
    }else {
        window.location.href = '../../index.php?page=rgs';
    }
    </script>";
}
