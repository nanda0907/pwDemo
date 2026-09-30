<?php
$host     = "aws-0-ap-southeast-1.pooler.supabase.com";
$port     = "5432";
$dbname   = "postgres";
$user     = "postgres.ngfrhcaovfqygargeyby";
$password = "npg_gr3XPBodOKv8";



$conn = pg_connect(
    "host=$host port=$port dbname=$dbname user=$user password=$password sslmode=$sslmode"
);

if (!$conn) {
    die("Koneksi database gagal. Periksa host, username, password, dan sslmode.");
}

echo "Koneksi database berhasil!";
?>