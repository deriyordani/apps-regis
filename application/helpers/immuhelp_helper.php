<?php
//	BEGIN of TIME FORMAT
function time_format($the_time, $format){
	return date($format, strtotime($the_time));
}
//	END of TIME FORMAT

// 	BEGIN of SMART FORM
function select_set($form_value, $exist_value){
	if($form_value == $exist_value){
		return ' selected="selected"';
	}
}

function check_set($form_value, $exist_value){
	if(is_array($exist_value)){
		foreach($exist_value as $ev){
			if($form_value == $ev){
				return ' checked="checked"';
				break;
			}
		}	
	}
	else{
		if($form_value == $exist_value){
			return ' checked="checked"';
		}
	}
}

function radio_set($form_value, $exist_value){
	if($form_value == $exist_value){
		return ' checked="checked"';
		break;
	}
}
//	END of SMART FORM


//	BEGIN of POST NAME
function post_name($str){
	//	remove HTML tags
	$str = strip_tags($str);
	
	//	remove these character
	$ell = array('`','~','!','@','#','$','%','^','&',';',':',"'",'\\','.','/','?', '"', ',');		
	$str = str_replace($ell, "", $str);
	
	//	remove space before and after string
	$str = trim($str);
	
	//	replace
	$str = preg_replace("![^a-z0-9]+!i", "-", $str);
	
	$str = strtolower($str);
	
	return $str;
}
//	END of POST NAME

function current_time(){	
	date_default_timezone_set('Etc/GMT-7');
	$datestring = "Y-m-d H:i:s";
	
	return date($datestring);
}

//	BEGIN of VALUE FORMAT
function value_format($value=0, $thou_sep=".", $dec_sep=",", $dec_digi=0){
	return number_format($value, $dec_digi, $dec_sep, $thou_sep);
}
//	END of VALUE FORMAT

//	BEGIN of MONTH NAME
function month_name($no = NULL){
	switch($no){
		case 1	:	$name = "Januari";		break;
		case 2	:	$name = "Februari";		break;
		case 3	:	$name = "Maret";		break;
		case 4	:	$name = "April";		break;
		case 5	:	$name = "Mei";			break;
		case 6	:	$name = "Juni";			break;
		case 7	:	$name = "Juli";			break;
		case 8	:	$name = "Agustus";		break;
		case 9	:	$name = "September";	break;
		case 10	:	$name = "Oktober";		break;
		case 11	:	$name = "November";		break;
		case 12	:	$name = "Desember";		break;		
	}
	
	return $name;
}

function combo_month($frm_var = "fMonth", $value = NULL){
	if($value != NULL){
		?>
		<select name="<?=$frm_var?>">
		<option value="">-- pilih --</option>
		<?php
			for($i=1; $i<=12; $i++){
				?><option value="<?=$i?>" <?=select_set($i, $value)?> ><?=month_name($i)?></option><?php
			}
		?></select><?
	}
	else{
		?>
		<select name="<?=$frm_var?>">
			<option value="">-- pilih --</option>
			<option value="1" selected="selected">Januari</option>
			<option value="2">Februari</option>
			<option value="3">Maret</option>
			<option value="4">April</option>
			<option value="5">Mei</option>
			<option value="6">Juni</option>
			<option value="7">Juli</option>
			<option value="8">Agustus</option>
			<option value="9">September</option>
			<option value="10">Oktober</option>
			<option value="11">November</option>
			<option value="12">Desember</option>
		</select>
		<?php	
	}
}
//	END of MONTH NAME 

//	BEGIN of UNIQUE CODE
function unique_code($unique = NULL){
	$date = date_create();
	if ($unique == NULL) {
		$unique = rand(10,99);
	}
	$code = $unique."-".substr(date_timestamp_get($date), -5)."-".rand(10,99);

	return $code;
}
//	END of UNIQUE CODE


function thousand_separator($value=0, $thou_sep=".", $dec_sep=",", $dec_digi=0){
	return number_format($value, $dec_digi, $thou_sep, $dec_sep);
}

function auto_number($value = NULL){
	date_default_timezone_set('Etc/GMT-7');
	$datestring = "Ymd-Hms";

	$date = $value."-".date($datestring);

	return $date;
}

function accound_id(){
	$date = date_create();
	$unique = rand(10,99);
	$code = $unique.substr(date_timestamp_get($date), -5).rand(10,99);

	return $code;
}

function no_pendaftaran(){
	$date = date_create();
	$unique = rand(10,99);
	$code = $unique.substr(date_timestamp_get($date), -5).rand(10,99);

	return $code;
}

function numbertell($x){
	$abil = array(
			"", 
			"Satu", "Dua", "Tiga", 
			"Empat", "Lima", "Enam", 
			"Tujuh", "Delapan", "Sembilan", 
			"Sepuluh", "Sebelas"
	);
	
	if ($x < 12) 
	 return " ".$abil[$x];
	elseif ($x<20) 
	 return numbertell($x-10)." Belas";
	elseif ($x<100) 
	 return numbertell($x/10)." Puluh".numbertell($x%10);
	elseif ($x<200) 
	 return " Seratus".numbertell($x-100);
	elseif ($x<1000) 
	 return numbertell($x/100)." Ratus".numbertell($x % 100);
	elseif ($x<2000) 
	 return " Seribu".numbertell($x-1000);
	elseif ($x<1000000) 	
	 return numbertell($x/1000)." Ribu".numbertell($x%1000);
	elseif ($x<1000000000) 
	 return numbertell($x/1000000)." Juta".numbertell($x%1000000);
	elseif ($x<1000000000000) 
	 return numbertell($x/1000000000)." Milyar".numbertell($x%1000000000);
	elseif ($x<1000000000000000) 
	 return numbertell($x/1000000000000)." Trilyun".numbertell($x%1000000000000);
}

//	BEGIN of INDONESIAN TIME FORMAT
function indonesian_time_format($timestamp = '', $date_format = '', $suffix = '') {
    if (trim ($timestamp) == '')
    {
            $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
        $timestamp = strtotime ($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
        'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
        'Oktober','November','Desember',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
    $date = ($suffix)?"{$date} {$suffix}":"{$date}";
    return $date;
}
//	END of INDONESIAN TIME FORMAT

?>