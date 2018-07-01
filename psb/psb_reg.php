<?php 





//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_reg.php";
$judul = "Pendaftaran Calon Peserta Didik";
$judulku = $judul;
$diload = "document.formx.nama.focus();";



//ketahui nomer pendaftaran
$qpd = mysql_query("SELECT COUNT(no_daftar) AS noreg ".
						"FROM psb_siswa_calon");
$rpd = mysql_fetch_assoc($qpd);
$pd_noreg = nosql($rpd['noreg']);
$nilx = "12300";
$nilx2 = "$tahun$nilx";
$noregx = round($pd_noreg + $nilx2 + 1);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnOK'])
	{
	//nilai
	$noregx = nosql($_POST['noregx']);
	$nama = cegah($_POST['nama']);
	$tmp_lahir = cegah($_POST['tmp_lahir']);

	$lxtgl = nosql($_POST['lxtgl']);
	$lxbln = nosql($_POST['lxbln']);
	$lxthn = nosql($_POST['lxthn']);
	$tgl_lahir = "$lxthn:$lxbln:$lxtgl";

	$alamat = cegah($_POST['alamat']);
	$kelamin = nosql($_POST['kelamin']);
	$agama = cegah($_POST['agama']);
	$nm_ortu = cegah($_POST['nm_ortu']);
	$almt_ortu = cegah($_POST['almt_ortu']);
	$ker_ortu = cegah($_POST['ker_ortu']);
	$nm_wali = cegah($_POST['nm_wali']);
	$almt_wali = cegah($_POST['almt_wali']);
	$ker_wali = cegah($_POST['ker_wali']);
	$asal_sek = cegah($_POST['asal_sek']);
	$status_sek = cegah($_POST['status_sek']);
	$almt_sek = cegah($_POST['almt_sek']);
	$no_sttb = cegah($_POST['no_sttb']);
	$thn_lulus = nosql($_POST['thn_lulus']);
	$keahlian1 = nosql($_POST['keahlian1']);
	$keahlian2 = nosql($_POST['keahlian2']);
	$us_nilx = nosql($_POST['us_nilx']);
	$us_nily = nosql($_POST['us_nily']);


	//cek
	if (empty($nama))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//cek noreg dan nama, nama dan tgl lahir
		$qcc = mysql_query("SELECT * FROM psb_siswa_calon ".
								"WHERE (no_daftar = '$noregx' AND nama = '$nama') ".
								"OR (nama = '$nama' AND tgl_lahir = '$tgl_lahir')");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek iya
		if ($tcc != 0)
			{
			//re-direct
			$pesan = "Anda telah melakukan pendaftaran. Tidak bisa melakukan pendaftaran lagi.";
			$ke = $filenya;
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			mysql_query("INSERT INTO psb_siswa_calon(kd, no_daftar, nama, tmp_lahir, tgl_lahir, alamat, kelamin, agama, ".
							"nama_ayah, alamat_ayah, kerja_ayah, nama_wali, alamat_wali, kerja_wali, ".
							"asal_sekolah, status_sekolah, alamat_sekolah, no_sttb, tahun_lulus, ".
							"tgl_daftar) VALUES ".
							"('$x', '$noregx', '$nama', '$tmp_lahir', '$tgl_lahir', '$alamat', '$kelamin', '$agama', ".
							"'$nm_ortu', '$almt_ortu', '$ker_ortu', '$nm_wali', '$almt_wali', '$ker_wali', ".
							"'$asal_sek', '$status_sek', '$almt_sek', '$no_sttb', '$thn_lulus', ".
							"'$today')");



			//entry nilai UN ////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$qpel = mysql_query("SELECT * FROM psb_m_mapel ".
									"ORDER BY mapel ASC");
			$rpel = mysql_fetch_assoc($qpel);

			do
				{
				$nomer = $nomer + 1;
				$xx = md5("$x$nomer");
				$d_kd = nosql($rpel['kd']);

				//nilai mapel
				$xnil = "nil";
				$xnil1 = "$xnil$nomer";
				$xnilx = nosql($_POST["$xnil1"]);

				$xkom = "kom";
				$xkom1 = "$xkom$nomer";
				$xkomx = nosql($_POST["$xkom1"]);

				//nek empty
				if (empty($xnilx))
					{
					$xnilx = "00";
					}

				if (empty($xkomx))
					{
					$xkomx = "00";
					}


				//cek nol
				if (strlen($xnilx) == 1)
					{
					$xnilx = "0$xnilx";
					}

				if (strlen($xkomx) == 1)
					{
					$xkomx = "$xkomx"."0";
					}


				//nilai...
				$xnilku = "$xnilx.$xkomx";

				//entry
				mysql_query("INSERT INTO psb_siswa_calon_un(kd, kd_siswa_calon, kd_mapel, nilai) VALUES ".
								"('$xx', '$x', '$d_kd', '$xnilku')");
				}
			while ($rpel = mysql_fetch_assoc($qpel));



			//entry nilai US ////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//nek empty
			if (empty($us_nilx))
				{
				$us_nilx = "00";
				}

			if (empty($us_nily))
				{
				$us_nily = "00";
				}


			//cek nol
			if (strlen($us_nilx) == 1)
				{
				$us_nilx = "0$us_nilx";
				}

			if (strlen($us_nily) == 1)
				{
				$us_nily = "$us_nily"."0";
				}


			//nilai...
			$us_nil = "$us_nilx.$us_nily";


			//insert
			mysql_query("INSERT INTO psb_siswa_calon_us(kd, kd_siswa_calon, nilai) VALUES ".
							"('$x', '$x', '$us_nil')");




			//re-direct ke pemberian akses user /////////////////////////////////////////////////////////////////////////////////////////
			$ke = "psb_reg_akses.php?userkd=$x&noregx=$noregx";
			xloc($ke);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi *START
ob_start();


//js
require("../inc/js/number.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';
echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="left">
<td width="25%">';
//ambil data menu
require("../inc/menu/psb_menu.php");
echo '</td>

<td align="left">
<big><strong>'.$judul.'</strong></big>
<br>';


//cek, sudah aktif belum seleksi.
$qcc = mysql_query("SELECT * FROM psb_set_seleksi");
$rcc = mysql_fetch_assoc($qcc);
$cc_seleksi = nosql($rcc['seleksi']);

//jika tidak aktif, pendaftaran masih diijinkan. ////////////////////////////////////////////////////////////////////////////////////////
if ($cc_seleksi == "false")
	{
	echo '<table>
	<tr>
	    <td width="23" height="21">
	    <p></p>
	    </td>
	    <td width="200 height="21">
	    <p>No. Pendaftaran :  </p>
	    </td>
	    <td width="7" height="21">
	    <p></p>
	    </td>
	    <td width="535" height="21">
		<input name="no_reg" type="text" size="10" value="'.$noregx.'" disabled>
		</td>
	</tr>
	</table>
	<br>
	<strong>IDENTITAS PESERTA</strong>
	<br>
	<table border="0" cellpadding="0" cellspacing="0" >
	    <tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>1. Nama : </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
			</td>
	        <td width="535" height="21">
			<input name="nama" type="text" size="30" maxlength="30">
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
	        <td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>2. TTL : </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
			<td width="535" height="21">
			<input name="tmp_lahir" type="text" value="" size="20">,
				<select name="lxtgl">
					<option value="" selected></option>';
						for ($i=1;$i<=31;$i++)
							{
							echo '<option value="'.$i.'">'.$i.'</option>';
							}
				echo '</select>
				<select name="lxbln">
					<option value="" selected></option>';
					for ($j=1;$j<=12;$j++)
						{
						echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
						}
				echo '</select>
				<select name="lxthn">
					<option value="" selected></option>';
						for ($k=$lahir01;$k<=$lahir02;$k++)
							{
							echo '<option value="'.$k.'">'.$k.'</option>';
							}
				echo '</select>
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
	        <td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>3. Alamat : </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
			<td width="535" height="21">
			<input name="alamat" type="text" size="50">
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
	        <td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>4. Jenis Kelamin (L/P) :  </p>
    	    </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
	        <td width="535" height="21">
			<select name="kelamin">
				<option value="" selected></option>
				<option value="L">Laki-Laki</option>
				<option value="P">Perempuan</option>
			</select>
			</td>
			</tr>
		<tr height="5"></TR>
		<tr>
	        <td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>5. Agama :  </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
			<td width="535" height="21">
			<select name="agama">
				<option value="" selected></option>
				<option value="Islam">Islam</option>
				<option value-"Kristen">Kristen</option>
				<option value="Katholik">Katholik</option>
				<option value="Budha">Budha</option>
				<option value="Hindu">Hindu</option>
				<option value="Konghuchu">Konghuchu</option>
			</select>
			</td>
		</tr>
	</table>
	<br>
	<strong>IDENTITAS ORANG TUA </strong>
	<table border="0" cellpadding="0" cellspacing="0" >
	    <tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200" height="21">
	        <p>1. Nama Orang Tua / Ayah  </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
			<td width="535" height="21">
			<input name="nm_ortu" type="text" size="20">
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200" height="21">
	        <p>2. Alamat Orang Tua / Ayah   </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
			<td width="535" height="21">
			<input name="almt_ortu" type="text" size="50">
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
    	    <td width="200" height="21">
	        <p>3. Pekerjaan Orang Tua / Ayah </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
			<td width="535" height="21">
			<select name="ker_ortu">
				<option value="" selected></option>
				<option value="PNS">PNS</option>
				<option value="TNI/POLRI">TNI/POLRI</option>
				<option value="Swasta">Swasta</option>
				<option value="Tani">Tani</option>
				<option value="Buruh">Buruh</option>
			</select>
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
    	    <p>4. Nama Wali </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
	        <td width="535" height="21">
			<input name="nm_wali" type="text" size="20">
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>5. Alamat Wali : </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
	        <td width="535" height="21">
			<input name="almt_wali" type="text" size="50">
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>6. Pekerjaan Wali </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
	        <td width="535" height="21">
			<select name="ker_wali">
				<option value="" selected></option>
				<option value="PNS">PNS</option>
				<option value="TNI/POLRI">TNI/POLRI</option>
				<option value="Swasta">Swasta</option>
				<option value="Tani">Tani</option>
				<option value="Buruh">Buruh</option>
			</select>
			</td>
		</tr>
		<tr height="5"></TR>
	</table>
	<br>
	<strong>ASAl SEKOLAH</strong>
	<br>
	<table>
		<tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>1. Asal Sekolah </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
	        <td width="535" height="21">
			<input name="asal_sek" type="text" size="30">
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
			<td width="23" height="21">
    	    <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>2. Status Sekolah </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
	        <td width="535" height="21">
			<select name="status_sek">
				<option value="" selected></option>
				<option value="Negeri">Negeri</option>
				<option value="Swasta">Swasta</option>
			</select>
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>3. Alamat Sekolah </p>
	        </td>
    	    <td width="7" height="21">
	        <p></p>
	        </td>
	        <td width="535" height="21">
			<input name="almt_sek" type="text" size="50">
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>4. No. STTB  </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
	        <td width="535" height="21">
			<input name="no_sttb" type="text" size="20">
			</td>
		</tr>
		<tr height="5"></TR>
		<tr>
			<td width="23" height="21">
	        <p></p>
	        </td>
	        <td width="200 height="21">
	        <p>5. Tahun Lulus </p>
	        </td>
	        <td width="7" height="21">
	        <p></p>
	        </td>
	        <td width="535" height="21">
			<input name="thn_lulus" type="text" size="4" onKeyPress="return numbersonly(this, event)">
			</td>
		</tr>
		<tr height="5"></TR>
	<table>
	<br>
	<strong>NILAI UJIAN NASIONAL</strong>
	<br>
	<table>
	<tr>
		<td width="23" height="21">
	    <p></p>
	    </td>
        <td width="200 height="21">
        <p></p>
        </td>
        <td width="7" height="21">
        <p></p>
        </td>
        <td width="535" height="21">
		<table width="400" border="1" cellspacing="0" cellpadding="3">
			<tr align="center" bgcolor="'.$warnaheader.'">
			<td width="1"><font color="'.$warnatext.'">No.</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Mata Pelajaran</font></strong></td>
			<td width="100"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
			</tr>';

			//ambil data mata pelajaran
			$qpel = mysql_query("SELECT * FROM psb_m_mapel ".
									"ORDER BY mapel ASC");
			$rpel = mysql_fetch_assoc($qpel);

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
				$d_kd = nosql($rpel['kd']);
				$d_mapel = balikin2($rpel['mapel']);

				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input name="kd'.$d_kd.'" type="hidden" value="'.$d_kd.'">
				'.$nomer.'
				</td>
				<td>'.$d_mapel.'</td>
				<td>
				<input name="nil'.$nomer.'" type="text" value="" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">,
				<input name="kom'.$nomer.'" type="text" value="" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
				</td>
				</tr>';
				}
			while ($rpel = mysql_fetch_assoc($qpel));

	echo '</table>
	</td>
	</tr>
	</table>
	<br>
	<table>
	<tr>
		<td width="200" height="21"><strong>RATA - RATA NILAI US</strong>
		</td>
		<td width="23 height="21">
	    <p></p>
	    </td>
	    <td width="7" height="21">
	    <p></p>
	    </td>
		<td width="535" height="21">
			<input name="us_nilx" type="text" value="" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">,
			<input name="us_nily" type="text" value="" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
		</td>
	</tr>
	</table>
	<br>

	<input name="noregx" type="hidden" value="'.$noregx.'">
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnOK" type="submit" value="OK &gt;&gt;&gt;">
	</td>
	</tr>
	</table>';
	}
else
	{
	echo '<font color="red"><strong>Pendaftaran Telah Ditutup.
	<br>
	<br>
	<br>
	Ttd. Panitia</strong></font>';
	}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>