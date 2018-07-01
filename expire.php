<?php
session_start();

//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");

nocache;

//hapus session
session_unset();
session_destroy();

//re-direct
$pesan = "Waktu Sesi Login Telah Habis. Silahkan Login Kembali...!!";
pekem($pesan,$sumber);
exit();
?>