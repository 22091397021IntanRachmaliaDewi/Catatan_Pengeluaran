<?php
// Mengambil session.php untuk memulai sesi pengguna
include("session.php");

// Inisialisasi variabel untuk kontrol tampilan tombol
$update = false; // Untuk mode update
$del = false; // Untuk mode delete

// Inisialisasi nilai default untuk input pengeluaran
$expenseamount = "";
$tanggal = date("Y-m-d");
$kategori = "Hiburan";

// Penanganan saat formulir disubmit dengan method POST
if (isset($_POST['add'])) {
    // Ambil nilai input dari formulir
    $expenseamount = 'Rp ' . number_format($_POST['expenseamount']); // Format nilai sebagai Rupiah
    $tanggal = $_POST['tanggal'];
    $kategori = $_POST['kategori'];

    // Query untuk menyimpan data pengeluaran ke database
    $expenses = "INSERT INTO expenses (user_id, pengeluaran, tanggal, kategori) VALUES ('$userid', '$expenseamount', '$tanggal', '$kategori')";
    $result = mysqli_query($con, $expenses) or die("Something Went Wrong!");

    // Redirect ke halaman tambah pengeluaran setelah operasi berhasil
    header('location: add_expense.php');
}

// Penanganan saat formulir disubmit untuk update data
if (isset($_POST['update'])) {
    $id = $_GET['edit']; // Ambil ID data yang akan diupdate
    $expenseamount = 'Rp ' . number_format($_POST['expenseamount']); // Format nilai sebagai Rupiah
    $tanggal = $_POST['tanggal'];
    $kategori = $_POST['kategori'];

    // Query untuk mengupdate data pengeluaran di database
    $sql = "UPDATE expenses SET pengeluaran='$expenseamount', tanggal='$tanggal', kategori='$kategori' WHERE user_id='$userid' AND pengeluaran_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    // Redirect ke halaman kelola pengeluaran setelah operasi berhasil
    header('location: manage_expense.php');
}

// Penanganan saat formulir disubmit untuk delete data
if (isset($_POST['delete'])) {
    $id = $_GET['delete']; // Ambil ID data yang akan dihapus

    // Query untuk menghapus data pengeluaran dari database
    $sql = "DELETE FROM expenses WHERE user_id='$userid' AND pengeluaran_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were deleted successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    // Redirect ke halaman kelola pengeluaran setelah operasi berhasil
    header('location: manage_expense.php');
}

// Penanganan saat permintaan GET untuk mengedit data
if (isset($_GET['edit'])) {
    $id = $_GET['edit']; // Ambil ID data yang akan diedit
    $update = true; // Aktifkan mode update
    // Ambil data pengeluaran dari database sesuai ID
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND pengeluaran_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        // Hapus format Rupiah dari nilai pengeluaran
        $expenseamount = str_replace(["Rp", ".", ","], "", $n['pengeluaran']);
        $tanggal = $n['tanggal'];
        $kategori = $n['kategori'];
    } else {
        // Pesan jika ada percobaan akses data yang tidak diizinkan
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}


// Penanganan saat permintaan GET untuk menghapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; // Ambil ID data yang akan dihapus
    $del = true; // Aktifkan mode delete
    // Ambil data pengeluaran dari database sesuai ID
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND pengeluaran_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        // Format nilai pengeluaran sebagai Rupiah
        $expenseamount = $n['pengeluaran'];
        $tanggal = $n['tanggal'];
        $kategori = $n['kategori'];
    } else {
        // Pesan jika ada percobaan akses data yang tidak diizinkan
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Catatan Pengeluaran - Tambah Pengeluaran</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Feather JS for Icons -->
    <script src="js/feather.min.js"></script>

</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
            <div class="user">
                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
                <h5><?php echo $username ?></h5>
                <p><?php echo $useremail ?></p>
            </div>
            <div class="sidebar-heading">Pengelolaan</div>
            <div class="list-group list-group-flush">
                <a href="index.php" class="list-group-item list-group-item-action"><span data-feather="home"></span> Dashboard</a>
                <a href="add_expense.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="plus-square"></span> Tambah Pengeluaran</a>
                <a href="manage_expense.php" class="list-group-item list-group-item-action"><span data-feather="clipboard"></span> Laporan Pengeluaran</a>
            </div>
            <div class="sidebar-heading">Pengaturan </div>
            <div class="list-group list-group-flush">
                <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
                <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


                <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
                    <span data-feather="menu"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="profile.phcol-mdp">Profile Saya</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container">
                <h3 class="mt-4 text-center">Tambahkan Pengeluaran Harian Anda</h3>
                <hr>
                <div class="row ">

                    <div class="col-md-3"></div>

                    <div class="col-md" style="margin:0 auto;">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="expenseamount" class="col-sm-6 col-form-label"><b>Masukkan Jumlah</b></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control col-sm-12" value="<?php echo $expenseamount; ?>" id="expenseamount" name="expenseamount" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-6 col-form-label"><b>Tanggal</b></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control col-sm-12" value="<?php echo $tanggal; ?>" name="tanggal" id="tanggal" required>
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-6 pt-0"><b>Kategori</b></legend>
                                    <div class="col-md">

                                        <!-- Your radio buttons for categories -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori" id="kategori4" value="Kesehatan" <?php echo ($kategori == 'Kesehatan') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="kategori4">
                                                Kesehatan
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori" id="kategori3" value="Makanan" <?php echo ($kategori == 'Makanan') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="kategori3">
                                                Makanan
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori" id="kategori2" value="Tagihan dan Isi Ulang" <?php echo ($kategori == 'Tagihan dan Isi Ulang') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="kategori2">
                                                Tagihan dan Isi Ulang
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori" id="kategori1" value="Hiburan" <?php echo ($kategori == 'Hiburan') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="kategori1">
                                                Hiburan
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori" id="kategori7" value="Pakaian" <?php echo ($kategori == 'Pakaian') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="kategori7">
                                                Pakaian
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori" id="kategori6" value="Transportasi" <?php echo ($kategori == 'Transportasi') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="kategori6">
                                                Transportasi
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori" id="kategori8" value="Kosmetik" <?php echo ($kategori == 'Kosmetik') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="kategori8">
                                                Kosmetik
                                            </label>
                                        </div>    
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kategori" id="kategori5" value="Lainnya" <?php echo ($kategori == 'Lainnya') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="kategori5">
                                                Lainnya
                                            </label>
                                        
                                        
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-md-12 text-right">
                                    <?php if ($update == true) : ?>
                                        <button class="btn btn-lg btn-block btn-warning" style="border-radius: 0%;" type="submit" name="update">Update</button>
                                    <?php elseif ($del == true) : ?>
                                        <button class="btn btn-lg btn-block btn-danger" style="border-radius: 0%;" type="submit" name="delete">Hapus</button>
                                    <?php else : ?>
                                        <button type="submit" name="add" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Tambah Pengeluaran</button>
                                    <?php endif ?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3"></div>
                    
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    <script>
        feather.replace();
    </script>
</body>
</html>
