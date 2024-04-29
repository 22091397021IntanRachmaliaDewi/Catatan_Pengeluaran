<?php
// header('Content-Type: application/vnd.api+json');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = mysqli_query($conn, "SELECT * FROM expenses");
    $count = $query->num_rows;
    $arr_data = array();
    while ($row = $query->fetch_assoc()) {
        $result = array(
            'pengeluaran_id' => $row['pengeluaran_id'],
            'user_id' => $row['user_id'],
            'pengeluaran' => $row['pengeluaran'],
            'tanggal' => $row['tanggal'],
            'kategori' => $row['kategori']
        );
    }

    if ($count == 0) {
        echo 'Tidak ada data';
    }else {
        echo json_encode(
            array($result)
        );
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $pengeluaran = $_POST['pengeluaran'];
    $tanggal = $_POST['tanggal'];
    $kategori = $_POST['kategori'];
    $query = mysqli_query($conn, "INSERT INTO expenses (user_id, pengeluaran, tanggal, kategori) VALUES ('$user_id', '$pengeluaran', '$tanggal', '$kategori')");

    if ($query) {
        $data = [
            'status' => 'data berhasil disimpan'
        ];

        echo json_encode([$data]);
    }else {
        $data = [
            'status' => 'data gagal disimpan'
        ];

        echo json_encode([$data]);
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $pengeluaran_id = $_GET['pengeluaran_id'];
    $query = mysqli_query($conn, "DELETE FROM expenses WHERE pengeluaran_id = '$pengeluaran_id' ");

    if ($query) {
        $data = [
            'status' => 'data berhasil dihapus'
        ];

        echo json_encode([$data]);
    }else {
        $data = [
            'status' => 'data gagal dihapus'
        ];

        echo json_encode([$data]);
    }

}elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $pengeluaran_id = $_GET['pengeluaran_id'];
    $user_id = $_GET['user_id'];
    $pengeluaran = $_GET['pengeluaran'];
    $tanggal = $_GET['tanggal'];
    $kategori = $_GET['kategori'];

    $query = mysqli_query($conn, "UPDATE expenses SET 
                            user_id = '$user_id',
                            pengeluaran = '$pengeluaran',
                            tanggal = '$tanggal',
                            kategori = '$kategori'
                            WHERE pengeluaran_id = '$pengeluaran_id'
                        ");
    
    if ($query) {
        $data = [
            'status' => 'data berhasil diedit'
        ];

        echo json_encode([$data]);
    }else {
        $data = [
            'status' => 'data gagal diedit'
        ];

        echo json_encode([$data]);
    }
}

?>