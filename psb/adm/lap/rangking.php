<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php");
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "rangking.php";
$judul = "Rangking";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}






//isi *START
ob_start();



//pemberian nomor urut rangking
$qpnu = mysql_query("SELECT * FROM psb_siswa_calon_rangking ".
						"ORDER BY round(total_rata) DESC");
$rpnu = mysql_fetch_assoc($qpnu);
$tpnu = mysql_num_rows($qpnu);

do
	{
	//nilai
	$nomex= $nomex + 1;
	$pnu_kd = nosql($rpnu['kd']);
	
	//update
	mysql_query("UPDATE psb_siswa_calon_rangking SET no = '$nomex' ".
					"WHERE kd = '$pnu_kd'");	
	}
while ($rpnu = mysql_fetch_assoc($qpnu));





//query data
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
				"psb_siswa_calon.nama AS scnama, psb_siswa_calon_rangking.* ".
				"FROM psb_siswa_calon, psb_siswa_calon_rangking ".
				"WHERE psb_siswa_calon.kd = psb_siswa_calon_rangking.kd_siswa_calon ".
				"AND psb_siswa_calon_rangking.nil_mapel >= '0' ".
				"AND psb_siswa_calon_rangking.nil_wwc <> '0' ".
				"AND psb_siswa_calon_rangking.nil_un <> '0' ".
				"AND psb_siswa_calon_rangking.nil_prestasi >= '0' ".
				"ORDER BY round(psb_siswa_calon_rangking.no) ASC";
$sqlresult = $sqlcount;
			
$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_adm.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="900" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">No.Daftar</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Skor Ujian Mapel</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Skor Wawancara</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Nilai UN</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Nilai Prestasi</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Nilai US</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Rata-Rata</font></strong></td>
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
			
		$d_kd = nosql($data['sckd']);
		$d_no = nosql($data['no']);
		$d_noreg = nosql($data['no_daftar']);
		$d_nama = balikin($data['scnama']);
		$d_nil_mapel = nosql($data['nil_mapel']);
		$d_nil_wwc = nosql($data['nil_wwc']);
		$d_nil_un = nosql($data['nil_un']);
		$d_nil_prestasi = nosql($data['nil_prestasi']);
		$d_nil_us = nosql($data['nil_us']);
		$d_total_rata = nosql($data['total_rata']);
		
			
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$d_no.'.</td>
		<td>'.$d_noreg.'</td>
		
		<td>'.$d_nama.'</td>

		<td>'.$d_nil_mapel.'</td>
		
		<td>'.$d_nil_wwc.'</td>
		
		<td>'.$d_nil_un.'</td>
		
		<td>'.$d_nil_prestasi.'</td>
		
		<td>'.$d_nil_us.'</td>
		
		<td>'.$d_total_rata.'</td>
		
        </tr>';				
		} 
	while ($data = mysql_fetch_assoc($result)); 
	}
	
	
echo '</table>
<table width="900" border="0" cellspacing="0" cellpadding="3">
<tr> 
<td align="right">
[<a href="rangking_prt.php" title="Print Laporan Rangking"><img src="'.$sumber.'/img/print.gif" width="16" height="16" border="0"></a>] 
'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
</tr>
</table>
</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>