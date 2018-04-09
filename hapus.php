<?php 
session_start();
if( !isset($_SESSION['login']) ) {
    header('Location: login.php');
    exit;
}
require "functions.php";

$id = $_GET["id"];

if( hapus($id) > 0 ) {
    echo "
            <script>
                alert('data berhasil dihapus');
                document.location.href = 'index.php';
            </script>
        ";
        header("Location, index.php");
    } else {
        echo "
            <script>
                alert('data gagal dihapus');
            </script>
        ";
}
?>