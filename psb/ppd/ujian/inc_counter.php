<?php
echo '<script language="JavaScript">

<!-- Begin
var up;
var min1,sec1;
var cmin1,csec1,cmin2,csec2;

	
function Display(min,sec) 
	{     
	var disp;       
	
	if(min<=9) disp=" 0";   
	else disp=" ";  
	disp+=min+":";  
	
	if(sec<=9) disp+="0"+sec;       
	else disp+=sec; 
	return(disp); 
	}
	
function Up() 
	{ 
	cmin1=0+'.$nil_mnt_seli.';         
	csec1=0+'.$nil_dtk_seli.';
	min1=0+'.$nil_mnt.'; 
	sec1=0+'.$nil_dtk.'; 

	UpRepeat(); 
	}
	
function UpRepeat() 
	{   
	csec1++;     

	if(csec1==60) 
		{
		csec1=0; cmin1++; 
		}
	
	document.formx.disp1.value=Display(cmin1,csec1);   
	if((cmin1>min1)&&(csec1>sec1)) 
		{
		location.href="'.$ke_sli.'";
		}
		
	else 
		{
		up=setTimeout("UpRepeat()",1000); 
		}
	}

// End -->
</script>';
?>