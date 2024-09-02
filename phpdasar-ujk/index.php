<?PHP
session_start();
session_regenerate_id(true);

require_once 'function/function.php';

if(isset($_POST['login'])){
$email = htmlspecialchars($_POST['email']);
$pass = htmlspecialchars($_POST['password']);
$opt = htmlspecialchars($_POST['options']);

if($opt == 2 || $opt == 3){
  $query = "SELECT * FROM user WHERE email = ?";
}else{
  header("Location: index.php?notif=login-gagal");
  exit();
}
$rslt = $db->prepare($query);
$rslt->bindParam(1, $email);
$rslt->execute();
$authentication = false;

while($row = $rslt->fetch(PDO::FETCH_ASSOC)){
  if(password_verify($pass, $row['password'])){
    if($row['id_level'] == $opt && $opt == "2"){
      $authentication = true;
      $_SESSION['emailAdmin'] = $row['email'];
      $_SESSION['userAdmin'] = $row['username'];
      header("Location: admin/index.php");
      exit();
    }elseif($row['id_level'] == $opt && $opt == "3"){
      $authentication = true;
      $_SESSION['emailSiswa'] = $row['email'];
      $_SESSION['userSiswa'] = $row['username'];
      header("Location: siswa/index.php");
      exit();
    }
  }
}
    // Jika otentikasi gagal
    if (!$$authentication) {
      header("Location: index.php?notif=login-gagal", true, 301);
      die();
  }
}
// Jika user sudah login, redirect ke halaman yang sesuai
if (isset($_SESSION["emailAdmin"]) && isset($_SESSION['userAdmin'])) {
  header("Location: admin/index.php");
  die();
}
if (isset($_SESSION["emailSiswa"]) && isset($_SESSION['userSiswa'])) {
  header("Location: siswa/index.php");
  die();
}
?>
<?php
  $title = "Login Pendaftaran";
  require_once 'layouts/html-header.php';
?>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image text-center my-5 px-5">
                              <img src="assets/img-layout/ppkd-jakarta-pusat.png" alt="" width="450">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login Now!</h1>
                                        <?php if(isset($_GET['notif']) == 'login-gagal'){?>
                                            <div id="myAlert" class="alert alert-danger">Gagal-Login</div>
                                        <?php }elseif(isset($_GET['notifs']) == 'logout-sukses'){?>
                                            <div id="myAlert" class="alert alert-success">Sukses-Logout</div>
                                        <?php }?>
                                    </div>
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                            name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="options">
                                              <option value="1">- CHOOSE -</option>
                                              <option value="2">ADMIN</option>
                                              <option value="3">SISWA</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" name="login">Login</button>
                                        <hr>
                                        <a href="#" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
  $scriptAlertLogin = "
  // Menggunakan JavaScript untuk menghilangkan alert setelah beberapa detik
  setTimeout(function(){
    $('#myAlert').fadeOut('slow');
    //Menghapus parameter status 
    history.replaceState({},document.title, window.location.pathname);
  }, 5000); // Alert akan hilang dalam 5 detik (5000 milidetik)
  ";
require_once 'layouts/html-footer.php';
?>
