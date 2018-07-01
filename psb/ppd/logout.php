<?php 


session_start();

//ambil nilai
require("../../inc/config.php"); 
require("../../inc/fungsi.php"); 

nocache;

//hapus session
session_unset($kd4_session);
session_unset($no4_session);
session_unset($nama4_session);
session_unset($ppd_session);
session_unset($username4_session);

session_unregister('$kd4_session');
session_unregister('$no4_session');
session_unregister('$nama4_session');
session_unregister('$ppd_session');
session_unregister('$username4_session');

//re-direct
$ke = "$sumber/psb/";
xloc($ke);
exit();
?>