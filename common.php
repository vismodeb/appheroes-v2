<?php
	
	// COPYRIGHTS  (C) NAMO FIBRE
	//$_froot =  $_SERVER['DOCUMENT_ROOT'].'/eazyadmin_demo/';
	//$_froot =  $_SERVER['DOCUMENT_ROOT'].'/';

	//if($_froot == '/app/' || $_froot == '//app/' || $_froot == '/')
    //$_froot = '/home/eazy1/appdemo/';
    //$_froot = '/home/eazy1/app2/';
    //$_froot = $_SERVER['DOCUMENT_ROOT'].'/eazybiz-admin/';

    //include $_froot.'assists/mail/class.phpmailer.php';


    function curl_post($url, $headers, $post){
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $url );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $post );
        $result = curl_exec($ch);
        curl_close( $ch );
        return $result;
    }

    function curl_get($url, $headers){
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $url );
        //curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        //curl_setopt( $ch,CURLOPT_POSTFIELDS, $post );
        $result = curl_exec($ch);
        curl_close( $ch );
        return $result;
    }
	
	function locTime(){
		return date('Y-m-d H:i:s', time()+3600);
	}

	
	function enCryptString($string){
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5('SALTYINDEX123'), $string, MCRYPT_MODE_CBC, md5(md5('SALTYINDEX123'))));
	}
	
	function deCryptString($string){
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5('SALTYINDEX123'), base64_decode($string), MCRYPT_MODE_CBC, md5(md5('SALTYINDEX123'))), "\0");
	}
	
	function list_table_value($table, $primary_key, $field, $value)
	{
		$sql = "select * from $table where $primary_key = '$value'";
		$mydb = new db();
		$d = $mydb->fetch_data($sql);
		return $d[$field];
	}
	
	function numeric_select($name, $stop, $start = 0, $empty_field_desc = '', $style = "basic")
	{
		global $data;
		echo '<select name="'.$name.'" id = "'.$name.'" class= "'.$style.'" >';
		
		
		
		if(!empty($empty_field_desc))
			echo '<option value = "" > '.$empty_field_desc.' </option>';
		
		for ($i = $start; $i <= $stop; $i ++)
		{
			$selected = (isset($_GET[$name]) && $_GET[$name] == $i) ? ' selected ' : '';
			echo '<option value="'.$i.'" '.$selected.'> '.$i.' </option>';
		}
		
		echo '</select>';
	}
		
	function preview_ads($format)
	{
		global $data;
		if ($format == 'f1')
		{
			$h = 90; $w = 729;
			$filename = $data['filename'];
			$type = $data['type'];
		}
		else if ($format == 'f2' )
		{
			$h = 578; $w = 160;
			$filename = $data['filename2'];
			$type = $data['type2'];
		}
		else if ($format == 'f3' )
		{
			$h = 250; $w = 300;
			$filename = $data['filename3'];
			$type = $data['type3'];
		}
		
		if(empty($filename))
		{
			echo '<div style = "font-size:12px; padding:10px">Sorry No File UPloaded for this Format</div>';
			return;
		}
					
					
		if ($type == 'application/x-shockwave-flash')
		{
			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'.$w.'" height="'.$h.'">
					<param name="movie" value="" />
					<param name="quality" value="high" />
					<embed src="../ads/'.$filename.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$w.'" height="'.$h.'"></embed>
			</object>';
		}
		else
		{
			echo '<a href = "'.$data['link'].'"><img src = "../ads/'.$filename.'" ></a>';
		}
				
	}
	
	function get_domain($domain)
	{
		if(substr($domain,0,4) == 'www.')
			$domain = substr($domain,4,strlen($domain) - 4);
		else if(substr($domain,0,11) == 'http://www.')
			$domain = substr($domain,11,strlen($domain) - 11);
		else if(substr($domain,0,7) == 'http://')
			$domain = substr($domain,7,strlen($domain) - 7);
		if(substr($domain,strlen($domain) - 1,1) == '/')
			$domain = substr($domain,0,strlen($domain) -1);	
		return $domain;
	}
	
	
	
	function pad_array($arr,$len,$val)
	{
		for($i = 0; $i < $len; $i++)
		{
			if(empty($arr[$i]) || !isset($arr[$i]) )
				$arr[$i] = $val; 
		}
		return $arr;
	}
	
	function comma_value($value, $decimal = 2)
	{
		/**$value = explode('.',$value);
		$integer_part = $value[0];
		$decimal_part = !empty($value[1]) ? $value[1] : '';
		$result = number_format($integer_part, 2);
		if(!empty($decimal_part))
			$result = $result.'.'.$decimal_part;
		else
			$result = $result; **/
		if(empty($value))
			return '0.00';
		else
			return number_format($value, $decimal);
	}
	
	
	function each_comment($data,$page = "")
	{
		global $_member_id,$item_owner;
		if($data['show_number'] == 1)
			$phone_number = " <span class = 't11' style = 'font-weight:normal; color:#BBBBBB' >( Mobile : {$data['mobile_number']} )</span>";
		else
			$phone_number = "";
		echo '<div class="each_comment">
				<div class="commentor">'.ucfirst($data['first_name']).' '.ucfirst($data['last_name']).$phone_number.'
					<div class = "each_vendor_phone">'.format_date($data['date']).'</div>
					</div>
					<div class = "each_vendor_description" style = "margin:0px; padding:0px" >'.$data['comment'].'</div>';
		if($_member_id == $data['member_id'] || $item_owner == $_member_id )
			echo '<div style = "text-align:right; font-size:10px"><a href = "javascript:;" onclick = "go_there(\''.$page.'&delcomment&comment_id='.$data['comment_id'].'\',\'Are you sure you want to delete this comment?\')">. delete</a></div>';
		
		echo '</div>';
	}

	
	function displayad(){
		
		echo '<div id="ad_column" >
				<img src="'.ROOT.'images/adsby.gif" />
			</div>';
	
	}
	
	function image_rating($vendor_id){
		$sql = "select * from ratings where vendor_id = '$vendor_id' ";
		$data = getdata($sql);
		if(!empty($data))
			$rating = round($data['rating']);
		else
			$rating = 0;
		for($i = 0; $i < 5; $i++){
			if($rating > $i)
				echo '<img src = "'.ROOT.'/images/star.gif" />';
			else
				echo '<img src = "'.ROOT.'/images/nullstar.gif" />';
		}
		$rating = (!empty($data['rating'])) ? $data['rating'].' of 5' : ' not rated ';
		echo ' <span class = "rating"> '.$rating.' </span>';
	}
	
	function issetvar($var,$location = 'index.php'){
		if(!isset($var)){
			echo '<script type="text/javascript">
					setTimeout("parent.location=\''.$location.'\'","5");
				  </script>';
			exit;
		}
	}
	
	function isemptyvar($var,$location = 'index.php'){
		if(empty($var)){
			//header('location:'.$location);
			echo '<script type="text/javascript">
					setTimeout("parent.location=\''.$location.'\'","30");
				  </script>';
		
			exit;
		}
	}
	
	function print_data($str)
	{
		global $data;
		if(!empty($data[$str]))
			return $data[$str];
		else 
			return '--';
	}
					
	function print_id_data($id,$table,$key,$display_field)
	{
		$sql = "select * from $table where $key = '$id'";
		$data = getdata($sql);
		if(!empty($data[$display_field]))
			return $data[$display_field];
		else 
			return '--';
	}
	
	
	
	
	
	
	function jscalendar($button,$display, $showsTime = 'false', $mod = 2)
	{
	
		echo '<script type="text/javascript"> 
					Calendar.setup({
						inputField     :    "'.$display.'",     // id of the input field
						ifFormat       : ';
	
		if($mod == 1)
			echo '   "%d-%m-%Y" ';
		else if($mod == 2 && $showsTime == 'true')
			echo '    "%Y-%m-%d %H:%M:%S" ';
		else
				echo '    "%Y-%m-%d" ';
	
		echo ',     // format of the input field (even if hidden, this format will be honored)
							  // ID of the span where the date is to be shown
						showsTime       : '.$showsTime.',
						time: 0000,
						daFormat       :    "%A, %B %d, %Y",// format of the displayed date
						button         :    "'.$button.'",  // trigger button (well, IMG in our case)
						align          :    "BR",           // alignment (defaults to "Bl")
						singleClick    :    true,
						weekNumbers     :	false	
					});
				</script>	';
	}
	
	
	
	function radiocheck1($var,$val)
	{
		
		global $data;
		if(isset($data[$var]) && $data[$var] == $val)
			return 'checked="checked"';
		else if(isset($_SESSION[$var]) && $_SESSION[$var] == $val)
			return 'checked = "checked" ';
		else if(isset($_GET[$var]) && $_GET[$var] == $val)
			return 'checked = "checked" ';
	}
	
	
	
	
	
	function radiocheck($var,$val,$default = 0)
	{
		global $data;
		if(isset($data[$var]) && $data[$var] == $val)
			echo 'checked="checked"';
		else if(isset($_SESSION[$var]) && $_SESSION[$var] == $val)
		{
			echo 'checked = "checked" ';
			unset($_SESSION[$var]);
		}
		else if(isset($_GET[$var]) && $_GET[$var] == $val)
			echo 'checked = "checked" ';
		else if($default == 1 && !isset($_SESSION[$var]) && !isset($_GET[$var]) && !isset($data[$var]) )
			echo 'checked = "checked" ';
	}
	
	
	
	function managetabs($val,$default = "")
	{
		if(!isset($_GET['tab']) && !empty($default) )
			echo ' class="selected"  ';
		else if(isset($_GET['tab']) && $_GET['tab'] == $val)
			echo ' class="selected" ';
	}
	
	function displaydiv($var,$val)
	{
		global $data;
		if(isset($data[$var]) && $data[$var] == $val)
			echo 'style = "display:block"';
		else if(isset($_SESSION[$var]) && $_SESSION[$var] == $val)
			echo 'style = "display:block" ';
		else if(isset($_GET[$var]) && $_GET[$var] == $val)
			echo 'style = "display:block" ';
	}
	
	function displaytab($val,$default = "",$tab = "tab")
	{
		if(!isset($_GET[$tab]) && !empty($default) )
			echo ' style = "display:block" ';
		else if(isset($_GET[$tab]) && $_GET[$tab] == $val)
			echo ' style = "display:block" ';
		else
			echo ' style = "display:none" ';
	}
	
	function display_radio($var,$val,$default = FALSE)
	{
		if(!isset($_GET[$var]) && ($default) )
			echo ' checked = "checked" ';
		else if(isset($_GET[$var]) && $_GET[$var] == $val)
			echo ' checked = "checked" ';
	}
	
	
	function echo_hr($name)
	{
		global $data;
		$newvar = "_".$name;
		echo '<select name="'.$name.'" id = "'.$name.'">
				 <option value = "">Hour.</option>';
		
		for($i = 0; $i <= 24; $i++)
		{
			echo '<option value = "'.$i.'"';
			
			if(isset($data[$name]) && $data[$name] == $i )
			{
				echo ' selected ';
				global $$newvar;
				$$newvar =1;
			}
			else if (isset($_SESSION[$name]) && $_SESSION[$name] == $i && !isset($$newvar))
			{
				echo ' selected ';
				unset($_SESSION[$name]);
			}
			
			echo ' >'.$i.'</option>';
		}
		
		echo '</select>';
	
	}
	
	
	
	function echo_min($name)
	{
		
		global $data;
		$newvar = "_".$name;
		echo '<select name="'.$name.'" id = "'.$name.'" >
				 <option value = "">Min.</option>';
		
		for($i = 0; $i <= 60; $i = $i + 10)
		{
			echo '<option value = "';
			
			if($i < 10)
				echo 0;
			
			echo $i.'"';
			
			if(isset($data[$name]) && $data[$name] == $i )
			{
				echo ' selected ';
				global $$newvar;
				$$newvar =1;
			}
			else if (isset($_SESSION[$name]) && $_SESSION[$name] == $i && !isset($$newvar) )
			{
				echo ' selected ';
				unset($_SESSION[$name]);
			}
			echo '>';
			
			if($i < 10)
				echo 0;
			
			echo $i.'</option>';
		}
		
		echo '</select>';
	
	}
	
	
	
	function echouser()
	{
		global $user_id;
		$sql = "select * from users where id = '$user_id'";
		$data = getdata($sql);
		return $data['name'];
	}
	
	
	
	
	function parseCalendarDate($date,$lower = "")
	{
	
		$ar = explode('-',$date);
		if ($lower == "")
			return mktime(0, 0, 0,trim($ar[1]),trim($ar[0]),trim($ar[2]));
		else
			return mktime(23, 59, 59,trim($ar[1]),trim($ar[0]),trim($ar[2]));
			
	}
	
	
	function parseSeconds($seconds)
	{
		global $hours, $mins;
		$hours = "00 ";
		$mins = "00 ";
		if ($seconds / 3600 > 1)
		{
			$hours = floor($seconds / 3600);
			$seconds = $seconds % 3600;
		}
		if ($seconds / 60 > 1)
		{
			$mins = floor($seconds / 60);
		}
		return $hours." : ".$mins;
	}
	
	
	function convert_to_seconds($time)
	{
		$items = explode(':',$time);
		$items = array_pad($items,3,'00');
		if(substr($items[2],3,2) == 'PM')
			$items[0] = $items[0] + 12;
		$result = ($items[0] * 3600) + ($items[1] * 60) + substr($items[2],0,2);
		return $result;
	}
	
	
	
	function parseDuration($date,$now = 1,$date2 = "")
	{
			if ($now == 1)
				$time_elapsed = time() - $date;
			else if ($now == 2)
				$time_elapsed = $date2 - $date;
			else if ($now == 3)
				$time_elapsed = $date;
				
			$result = '';
			
			
			if ($time_elapsed / (24 * 3600) > 1)
			{
				$days = floor($time_elapsed / (86400));
				$s = ($days > 1) ? 's' : '';
				$result .= "<span class = 'time_days'>$days day$s</span> ";
				$time_elapsed = $time_elapsed % 86400;
			}
			//return $time_elapsed;
			
			if ($time_elapsed / 3600 > 1)
			{
				$hours = floor($time_elapsed / 3600);
				$s = ($hours > 1) ? 's' : '';
				$result .= "$hours hr$s : ";
				$time_elapsed = $time_elapsed % 3600;
			
			}
			
			if ($time_elapsed / 60 > 1)
			{
				$mins = floor($time_elapsed / 60);
				$s = ($mins > 1) ? 's' : '';
				$result .= "$mins mn$s : ";
				$time_elapsed = $time_elapsed % 60;
				
			}
			
			if ($time_elapsed > 0)
			{
				$s = ($time_elapsed > 1) ? 's' : '';
				$result .= "$time_elapsed sc$s";
			}
			
			return $result;
			
	}
		
	function sub_select($sub_id)
	{
		echo '<script>
				regionState.printOptions("'.$sub_id.'");
			 </script>';
	
	}
	
	function populate_sub_cat_javascript($table1,$column1,$column2,$table2,$column3,$column4,$checker,$table2_alias = "")
	{
	    $db = new db();
		echo '<script language="JavaScript" type="text/javascript">
				var regionState = new DynamicOptionList();
				regionState.addDependentFields("'.$column2.'","'.$column4.'");
				regionState.forValue("").addOptionsTextValue("- select category - ","");';
		global $data;
		$sql = "select * from $table1 order by $column1 ";
		$result = $db->prepare($sql);
		
		while($dat = $db->fetch_row($result))
		{
			echo "regionState.forValue('".$dat[$column2]."').addOptionsTextValue(";
			$sql2 = "select * from $table2 where $column2 = '".$dat[$column2]."' order by $column3";
			$i = $db->num_rows($sql2);
			$result2 = $db->prepare($sql2);
			//$i = mysql_num_rows($result2);
			if (empty($i))
			{
				if(empty($table2_alias))
					echo "'- No $table2 - ',''";
				else
					echo "'- No $table2_alias - ',''";
			}
			else{
				
				echo "' - Select one - ','',";
				while ($data2 = $db->fetch_row($result2))
				{
					echo "'".ucfirst($data2[$column3])."','".$data2[$column4]."'";
					if ($i != 1)
						echo ',';
					$i--;
				}
			}
			
			echo ");\n";
		
		}
		
		if (isset($data[$checker]))
			echo 'regionState.forValue("'.$data[$column2].'").setDefaultOptions("'.$data[$checker].'");';
		else if(isset($_SESSION[$checker]))
			echo 'regionState.forValue("'.$_SESSION[$column2].'").setDefaultOptions("'.$_SESSION[$checker].'");';
		else if (isset($_GET[$checker]))
			echo 'regionState.forValue("'.$_GET[$column2].'").setDefaultOptions("'.$_GET[$checker].'");';
		echo '</script>';
	}
	
	
	
	function sub_cat_start($table_vars, $checker,$table2_alias = "",$table3_alias = "")
	{
		echo '<script language="JavaScript" type="text/javascript">
				var regionState = new DynamicOptionList();'."\n".'
				regionState.addDependentFields("';
		$concat = '';
		for($i = 0; $i < count($table_vars); $i ++)
				$concat .= $table_vars[$i][2].',';
		$concat = rtrim($concat,',');
		echo $concat;
		echo  '");'."\n";
		
		for($i = 0; $i < count($table_vars) - 1; $i++)
		{
			echo 'regionState.';
			
			for($j = 0; $j < $i + 1; $j++)
				echo 'forValue("").';
			
			echo 'addOptionsTextValue("- select category - ","");'."\n";
		
		}
		global $data;
		
		$sql = "select * from ".$table_vars[0][0]." order by ".$table_vars[0][1]." ";
		$result = mysql_query($sql);
		
		while($dat = mysql_fetch_array($result))
		{
			echo "regionState.forValue('".$dat[$table_vars[0][2]]."').addOptionsTextValue(";
			$sql2 = "select * from ".$table_vars[1][0]." where ".$table_vars[0][2]." = '".$dat[$table_vars[0][2]]."' order by ".$table_vars[1][2];
			$result2 = mysql_query($sql2);
			$i = mysql_num_rows($result2);
			if (empty($i))
			{
				if(empty($table2_alias))
					echo "'- No $table2 - ',''";
				else
					echo "'- No $table2_alias - ',''";
			}
			else
			{
				echo "' - Select one - ','',";
				while ($data2 = mysql_fetch_array($result2))
				{
					echo "'".ucfirst($data2[$table_vars[1][1]])."','".$data2[$table_vars[1][2]]."'";
					if ($i != 1)
						echo ',';
					$i--;
					
					// 3rd level deep.
					$third_level = "regionState.forValue('".$dat[$table_vars[0][2]]."').forValue('".$data2[$table_vars[1][2]]."').addOptionsTextValue(";
					$sql = "select * from ".$table_vars[2][0]." where ".$table_vars[1][2]." = '".$data2[$table_vars[1][2]]."' order by ".$table_vars[2][1];
					$result3 = mysql_query($sql);
					$rowsfound3 = mysql_num_rows($result3);
					if($rowsfound3 == 0)
					{
						if(empty($table3_alias))
							echo "'- No ".$table_vars[2][0]." - ',''";
						else
							echo "'- No $table3_alias - ',''";
					}else
					{
						while($data3 = mysql_fetch_array($result))
						{
							$third_level .= "'".ucfirst($data3[$table_vars[2][1]])."','".$data3[$table_vars[2][2]]."', ";
						}
						$third_level = rtrim($third_level,', ');
						$third_level .= ");\n";
					}
					
				}
			}
			
			echo ");\n";
			echo $third_level;
			
			
		}
		
		if (isset($data[$checker]))
			echo 'regionState.forValue("'.$data[$table_vars[0][2]].'").setDefaultOptions("'.$data[$checker].'");';
		else if(isset($_SESSION[$checker]))
			echo 'regionState.forValue("'.$_SESSION[$table_vars[0][2]].'").setDefaultOptions("'.$_SESSION[$checker].'");';
		else if (isset($_GET[$checker]))
			echo 'regionState.forValue("'.$_GET[$table_vars[0][2]].'").setDefaultOptions("'.$_GET[$checker].'");';
		echo '</script>';
	}
	
	
	
	
	
	
	function selected2($s,$v)
	{
		if (isset($_SESSION[$s]) && $_SESSION[$s] == $v)
		{
			echo 'selected' ;
			return;
		}
	}
	
	
	function espost2($string)
	{
		if (isset($_SESSION[$string]))
		{
			
			
			echo stripslashes($_SESSION[$string]);
			//unset ($_SESSION[$string]);
		}
	
	}
	
	
	
	
	
	
	
	
	
	function create_select_box($data_field,$id,$name,$compare,$sql,$tabindex = "")
	{
		$newvar = '_selected'.$name;
		
		global $data;
		
		$result = mysql_query($sql);
		echo '<select name = "'.$name.'" id = "'.$name.'" class = "basic"';
		
		if(!empty($tabindex))
			echo ' tabindex = "'.$tabindex.'" ';
		
		echo '>
				<option value = ""> -- Select one --</option>';
		while($dat = mysql_fetch_array($result))
		{
			echo '<option value = "'.$dat[$id].'"';
			
			if (isset($data[$compare]) && $data[$compare] == $dat[$id])
			{
				echo ' selected ';
				global $$newvar;
				$$newvar = 1;
			}else if (isset($_GET[$compare]) && $_GET[$compare] == $dat[$id] && !isset($$newvar)  )
			{
			
				echo 'selected';
				global $$newvar;
				$$newvar = 1;
				
			
			}else if (isset($_SESSION[$compare]) && $_SESSION[$compare] == $dat[$id] && !isset($$newvar) )
				echo 'selected';
			
			
			echo '> '.$dat[$data_field].'</option>';
		
		
		}
		echo '</select>';
	
	}
	
	
	function select_box_10($name)
	{
		echo '<select name="'.$name.'" class= "basic" >';
		
		for ($i = 1; $i < 21; $i ++)
			echo '<option value="'.$i.'">'.$i.'</option>';
		
		echo '</select>';
	}
	
	function select_box11($name,$end,$count,$style = "")
	{
		echo '<select id = "'.$name.'" name = "'.$name.'" class = "'.$style.'" >';
		echo '<option value = "">-Select-</option>';
		 for ($i = 0; $i < $count; $i ++)
		 {
				echo '<option value = "'.$end.'"';
						
				selected($name,$end);
						
				echo ' >'.$end.'</option>';
				$end--;
		}
		echo '</select>';
	}
	
	
	
	
	
	
	
	function delete($table,$field,$value,$location)
	{
		$sql = "delete from $table where $field = '$value'";
		//echo $sql; exit;
		$result = mysql_query($sql);
		set_alert(0,"Record has been deleted",$location); 
	
	}
	
	
	function delete_record($table,$field,$location)
	{
		if (isset($_POST['del']))
		{
			$i = 0;
			foreach($_POST as $key => $value)
			{
				$sql = "delete from $table where $field = '$value'";
				mysql_query($sql);
				$i++;
			}
			$s = ($i > 1) ? 's' : ''; 
			set_alert(0,"Record$s deleted",$location); 
			
		}
	}
	
	
	
	
	
	function today_begins()
	{
		global $m,$d,$y;
		$d = date('j'); $m = date('n'); $y = date('Y');
		return mktime(0,0,0,$m,$d,$y);
		
	}
	
	
	
	function common_words()
	{
	
		return array('is','go','for','the','it','a','to','i','we',' ','are','you','they','want','as','come','or','at','what','was','our','those','do');
	
	}
	
	
	// function to upload image
	function upload_image($uploaddirf,$location,$filef,$m,$h,$max_size)
	{
		// Upload image
		
		// get variables from form and server
		global $filename, $tmpname , $filesize , $filetype;
	
		$filename = $_FILES[$filef]['name'];
		$tmpname = $_FILES[$filef]['tmp_name'];
		$filesize = $_FILES[$filef]['size'];
		$filetype = $_FILES[$filef]['type'];
		
		if (empty($filesize))
			set_alert('Error: ','No file was uploaded or the file is bigger than file limit',$location);
		
		$unwanted = array('%',"'","/","\\"," ","@","!","#","$","^","&","*","(",")","+","-","=");
		$filename = str_replace($unwanted,'',$filename);
		
		
		if ($filesize > $max_size)
			set_alert('Error: ','Sorry This file is bigger than the file limit',$location);
		
		
		// check if uploaded image is file
		global $photo_types;
		
		$photo_types = array(  
							 'image/pjpeg' => 'jpg', 
							 'image/jpeg' => 'jpg', 
							 'image/gif' => 'gif',  
							 'image/x-png' => 'png' 
							);
	
		if(!array_key_exists($filetype,$photo_types))
			set_alert('Error: ','Sorry this file type is not accepted',$location);
			
		$filename = make_file_name($filename,$filetype,$photo_types);
		
		global $filepath;
		
		$filepath = $uploaddirf.'/'.$filename;
		
		$move = move_uploaded_file($tmpname,$filepath);
		
		//exit;
		if (!$move)
			set_alert('Error: ', 'A problem occured while trying to upload the Picture, Please try again', $location);
		
		// Read the size of the uploaded image and resize if width its to wide
		// or length is too long
		global $width,$length;
		
		list($width,$length) = getimagesize($filepath);
		
		
		if ($width > $m )
		{
			$new_width = $m;
			$new_length = $m * ($length/$width);
			resize_image($filepath,$uploaddirf.'/',$filename,$filetype,$new_width,$new_length,$width,$length);
		}
		list($width,$length) = getimagesize($filepath);
		
		if ($length > $h)
		{
			$new_length = $h;
			$new_width = $h * ($width/$length);
			resize_image($filepath,$uploaddirf,$filename,$filetype,$new_width,$new_length,$width,$length);
			
		}
		list($width,$length) = getimagesize($filepath);
	
	}
	
	// generate filename to prevent overwriting
	function make_file_name($filenamef,$filetypef,$photo_types)
	{
		$time = substr(mktime(),3);
		$randomnumber = rand(0,100);
		$name = explode('.',$filenamef);
		$ext = $photo_types[$filetypef];
		$n = str_replace(' ','',$name[0]);
		$filename = $n.$time.$randomnumber.'.'.$ext;
		return $filename;
	}
	
	
	// resize image function
	function resize_image($sourcef,$destinationf,$filenamef,$filetypef,$nuwidthf,$nulengthf,$widthf,$lengthf)
	{
	
		$photo_typesf = array(  
							 'image/pjpeg' => 'jpeg', 
							 'image/jpeg' => 'jpeg', 
							 'image/gif' => 'gif', 
							 
							 'image/bmp' => 'wbmp', 
							 'image/x-png' => 'png' 
							);
		$functionsuffix = $photo_typesf[$filetypef];
		$functiontoread = 'imagecreatefrom'.$functionsuffix;
		$functiontowrite = 'image'.$functionsuffix;
		
		$imagehandle = imagecreatetruecolor($nuwidthf, $nulengthf);
		$file = $sourcef;
		$file2 = $destinationf.$filenamef;
		$image = $functiontoread($file);
		imagecopyresampled($imagehandle,$image,0,0,0,0,$nuwidthf,$nulengthf,$widthf,$lengthf);
		if($functiontowrite($imagehandle,$file2,100))
			return 1;
		else
			return 0;
	}
	
	
	
	// function to log error message as session variable
	function set_alert($type,$string,$location,$set = FALSE,$redirect_type = 'header')
	{
		if($set)
			foreach ($_POST as $key => $value)
				$_SESSION[$key] = $value;	
		$newstring = '<div class="posterror" ';
		
		if (substr($type,0,1) == 'e' || $type == '0' || substr($type,0,1) == 'E')
			$newstring .= ' id = "off" ';
		else if ($type == '2')
			$newstring .= '  id = "att"  ';
		else if ($type == '1' || substr($type,0,1) == 'g' || substr($type,0,1) == 'G')
			$newstring .= '   id = "ok"  ';
		
		$newstring .= ' >'.$string.'</div>';
		
		$_SESSION['error'] = $newstring;
		if($redirect_type == 'header')
			header('location:'.$location);
		else
		{
			echo '<script type="text/javascript">
					setTimeout("parent.location=\''.$location.'\'","5");
				  </script>';
			exit;
		}
		exit;
	}
	
	// set alert without registering post vars
	function set_alert2($type,$string,$location)
	{
		$newstring = '<div class="posterror"><span class="red"><strong>'.$type.' </strong></span>'.$string.'</div>';
		$_SESSION['error'] = $newstring;
		header('location:'.$location);
		exit;
	}
	// function to do the query and fetch in one piece
	function getdata($sqlf)
	{
		global $gdrows;
		$result = mysql_query($sqlf);
		$data = mysql_fetch_array($result);
		$gdrows = mysql_num_rows($result);
		return $data;
	}
	
	//funtion to addslashes automatically to each post
	// and set charaters to lower case
	
	function auto_addslashes()
	{
		/*if (!get_magic_quotes_gpc())
		{
			foreach ($_POST as $key => $value)
				$_POST[$key] = addslashes($value);
		}*/
	} 
	
	function stringToLower()
	{
		foreach ($_POST as $key => $value)
				$_POST[$key] = strtolower($value);
	}
	
	//funtion to fromat text
	function format_text($string)
	{
		
		$string = nl2br(htmlspecialchars($string));
		return str_replace('<br />','<br /><br />',$string);
		
		
	}
	
	// paste the alert
	function p_alert()
	{
		if (isset($_SESSION['error']))
			{
				echo $_SESSION['error'];
				unset($_SESSION['error']);
				global $p_alert;
				$p_alert = 1;
			}
		else
			{	
				global $p_alert;
				$p_alert = 0;
			}
	}
	
	//SET TIME
	function format_time($string)
	{
		return date("g:i a",$string);
	
	}
	
	function list_value($table,$key,$field_name,$value)
	{
		$sql = "select * from $table where $key = '$value'";
		$mydb = new db();
		$data = $mydb->fetch_data($sql);
		return $data[$field_name];
	}
	
	
	
	// set to date format
	function format_date($string,$notime="")
	{
		if(empty($notime))
			$date = date("g:ia d - M - Y  ",$string);
		else
			$date = date("d - M - Y  ",$string);
		return $date;
	}
	
	
	function espost($string,$date="")
	{
		global $data;
		if (isset($data[$string]))
		{
			
			if(!empty($date))
				echo stripslashes(date('j-n-Y',$data[$string]));
			else
				echo stripslashes($data[$string]);
		
		} 
		else if (isset($_SESSION[$string]))
		{
			if(!empty($date))
				echo stripslashes(format_date($_SESSION[$string],1));
			else
				echo stripslashes($_SESSION[$string]);
			unset ($_SESSION[$string]);
		}else if (isset($_GET[$string]))
		{
			if(!empty($date))
				echo stripslashes(format_date($_GET[$string],1));
			else
				echo stripslashes($_GET[$string]);
		}
	} 
	
	
	
	
	
	// funtion to echo data in option field
	
	function select_box($s)
	{
		
		if (isset($_SESSION[$s]))
		{
			echo '<option value = "'.$_SESSION[$s ].'">'.$_SESSION[$s ].'</option>';
			echo '<option value = "">- - - - - - </option>';
		}
	}	
	
	
			
	function selected($s,$v)
	{
		global $data;
		if (isset($data[$s]) && $data[$s] == $v)
		{
			echo 'selected';
			return;
		}
		else if (isset($_SESSION[$s]) && $_SESSION[$s] == $v)
		{
			echo 'selected' ;
			unset($_SESSION[$s]);
			return;
		} else if (isset($_GET[$s]) && $_GET[$s] == $v)
		{
			echo 'selected' ;
			unset($_SESSION[$s]);
			return;
		}
	}
	
	
	function checkbox($d)
	{
		global $data;
		if (isset($data[$d]) && $data[$d] == 1)
		{
			echo ' checked = "checked" ';
		}
		else if (isset($_SESSION[$d]))
			echo ' checked = "checked" ';
		else if(isset($_GET[$d]))
			echo ' checked = "checked" ';
		unset($_SESSION[$d]);
	
	}
	
	
	
	
	
	function break_word($str,$maxlen)
	{
		// break a very long word to prevent site distortion
		$items = explode(' ',$str);
		
		foreach($items as $key => $value)
		{	
			for($i = 0; $i < strlen($value); $i+=$maxlen)
			if (isset($result))
				$result .= substr($value,$i,$maxlen).' ';
			else
				$result = substr($value,$i,$maxlen).' ';
		}
		
		//$result = implode(' ',$items).'salad';
		return $result;
	}
	
	
	
	
	
	
?>