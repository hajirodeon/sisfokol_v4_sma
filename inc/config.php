<?php
//Detail Sekolah ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sek_nama = "SMA . . .";
$sek_alamat = "Jl. Raya . . .";
$sek_kontak = "Telp. . . .";
$sek_kota = "Kotaku";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//ALAMAT SITUS //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sumber = "http://localhost/sisfokol_v4_sma/";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//KONEKSI DATABASE //////////////////////////////////////////////////////////////////////////////////////////////////////////////
$xhostname = "localhost";
$xdatabase = "sisfokol_v4_sma";
$xusername = "biasawae";
$xpassword = "biasawae";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//koneksi ke GAMMU - SMS Gateway Server ////////////////////////////////////////////////////////////////////////////
$gammu_bin = '/usr/bin/gammu';
//$gammu_bin = 'c:\gammu\bin\gammu.exe';

$gammu_config = '/etc/gammurc';
$gammu_config1 = '/etc/gammu-smsdrc';
$gammu_config2 = '/etc/smsdrc';
//$gammu_config = 'c:\gammu\gammurc';

$gammu_cekpulsa = '*123#'; //xl

$gammu_config_section	= ''; //kosongkan aja
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//untuk fmath ///////////////////////////////////////////////////////////////////////////////////////
//silahkan edit juga, posisi folder untuk fmath
//yang berada di : /inc/class/tiny_mce/plugins/fmath_formula/configMathMLEditor.xml
/////////////////////////////////////////////////////////////////////////////////////////////////////







//JUMLAH DATA per HALAMAN ///////////////////////////////////////////////////////////////////////////////////////////////////////
$limit = "20";  //jumlah data dalam satu halaman
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//JENJANG PSB ////////////////////////////////////////////////////////////////////////////////////////////////////////////
$daft01 = "2012";
$daft02 = "2020";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//JENJANG surat ////////////////////////////////////////////////////////////////////////////////////////////////////////////
$surat01 = "2012";
$surat02 = "2020";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//JENJANG PEMBAYARAN ////////////////////////////////////////////////////////////////////////////////////////////////////////////
$bayar01 = "2007";
$bayar02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//JENJANG KALENDER ////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tpel01 = "2007";
$tpel02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//JENJANG PEMINJAMAN ////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pinjam01 = "2007";
$pinjam02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//JENJANG KELAHIRAN /////////////////////////////////////////////////////////////////////////////////////////////////////////////
$lahir01 = "1900";
$lahir02 = "2005";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//JENJANG TERIMA/BELI ///////////////////////////////////////////////////////////////////////////////////////////////////////////
$terima01 = "2000";
$terima02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//JENJANG TMT ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tmt01 = "1990";
$tmt02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//JENJANG SK Pertama ////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sk01 = "1990";
$sk02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//JENJANG tgl masuk /////////////////////////////////////////////////////////////////////////////////////////////////////////////
$masuk01 = "1990";
$masuk02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//JENJANG Tgl. STTB /////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sttb01 = "2000";
$sttb02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//JENJANG meninggalkan sekolah //////////////////////////////////////////////////////////////////////////////////////////////////
$tinggal01 = "2000";
$tinggal02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//JENJANG mulai bekerja /////////////////////////////////////////////////////////////////////////////////////////////////////////
$kerja01 = "2000";
$kerja02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//JENJANG TMT. Awal dan Akhir ///////////////////////////////////////////////////////////////////////////////////////////////////
$tmt01 = "2000";
$tmt02 = "2015";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//KONFIGURASI WARNA TABEL - DATA ////////////////////////////////////////////////////////////////////////////////////////////////
$warna01 = "#F8F8F8";
$warna02 = "#E3E1F9";
$warnaover = "#C7CBFA";
$warnaheader = "#C0C5EF";
$warnatext = "black";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//CHMOD utk. Upload Image ///////////////////////////////////////////////////////////////////////////////////////////////////////
$chmod = 0777;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//Lama-nya session //////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sesidt = 900; //detik
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//Jumlah baris dalam List Daftar Chat ///////////////////////////////////////////////////////////////////////////////////////////////////
$chatdatalist = "100";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>