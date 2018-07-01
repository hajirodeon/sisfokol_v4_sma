<?php
 



session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admks.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "mapel.php";
$judul = "Mata Pelajaran";
$judulku = "[$ks_session : $nip4_session.$nm4_session] ==> $judul";
$judulx = $judul;
$ke = $filenya;




//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admks.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//query
$q = mysql_query("SELECT * FROM m_mapel ".
					"ORDER BY round(no) ASC, ".
					"round(no_sub) ASC");
$row = mysql_fetch_assoc($q);
$count = mysql_num_rows($q);

echo '<table width="400" border="1" cellpadding="3" cellspacing="0">
<tr bgcolor="'.$warnaheader.'">
<td width="4%" valign="top"><strong>No.</strong></td>
<td valign="top"><strong>Mata Pelajaran</strong></td>
</tr>';

if ($count != 0)
	{
	do
  		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			}

		$nomer = $nomer + 1;

		$i_kd = nosql($row['kd']);
		$i_no = nosql($row['no']);
		$i_nosub = nosql($row['no_sub']);
		$i_pel = balikin2($row['pel']);
		$i_xpel = balikin2($row['xpel']);
		$i_mulo = nosql($row['mulo']);


		//jika muatan lokal
		if ($i_mulo == "true")
			{
			$i_pel2 = "Muatan Lokal --> $i_pel";
			}
		else
			{
			$i_pel2 = $i_pel;
			}


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">'.$nomer.'.</td>
		<td valign="top">'.$i_pel2.'</td>
		</tr>';
  		}
	while ($row = mysql_fetch_assoc($q));
	}

echo '</table>
</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>