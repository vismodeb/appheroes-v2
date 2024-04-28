<?PHP


	class db {
	
		var $mode;
		var $link;
		var $db;
		var $result;
		var $bind_fetch_count;

		function __construct($database = DATABASE, $host = HOST, $username = USERNAME, $password = PASSWORD, $mode = "mysql")
		{

            //rewriting dbadapter with objects instead
            $this->db = new mysqli($host, $username, $password, $database);

            if ($this->db->connect_errno)
                exit('Problem connecting to DB : '.$this->db->connect_errno);

		}
		
		function print_error()
		{
			if($this->db->error)
					echo '<span style = "font-size:24px; font-family:arial; font-weight:bold">'.$this->db->error.'</span>';
		}

		function error(){
            if($this->db->error)
                return $this->db->error;
            else
                return '';
        }

		function real_escape( $value ){

		    return $this->db->real_escape_string($value);
        }
		
		function bind_fetch_data($sql, $parameters_to_bind)
		{

		    $stmt = $this->db->prepare($sql);
		    $stmt->bind_param(...$parameters_to_bind);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->bind_fetch_count = $result->num_rows;
            return $result->fetch_assoc();

		}

        function bind_insert_data($sql, $parameters_to_bind)
        {

            $result = $this->db->prepare($sql);
            $result->bind_param(...$parameters_to_bind);
            $result->execute();

        }

        function fetch_data($sql)
        {
            $result = $this->db->query($sql);
            return $result->fetch_assoc();
        }

        function num_rows($sql)
        {
            $result = $this->db->query($sql);
            return $result->num_rows;

        }

        function insert_data($sql)
        {

            if(!$this->db->query($sql)){
                echo $this->db->error;
            }
        }

        function insert_id(){
		    return $this->db->insert_id;
        }

        function prepare($sql)
        {
                $this->result = $this->db->query($sql);
        }

		function fetch_row()
		{

		    if(!empty($this->db->error))
                echo '<span style = "font-size:24px; font-family:arial; font-weight:bold">'.$this->db->error.'</span>';

            return $this->result->fetch_assoc();

//            if (!empty($data))
//                if (!get_magic_quotes_gpc())
//                    foreach($data as $key => $value)
//                        $data[$key] = stripslashes($data[$key]) ;
//            return $data;
		}
		

		function select_in_sets($sql,$prows)
		{
			if($this->mode == 'mysql')
			{
				global $offset,$result,$rowsfound,$rows,$noffset,$poffset,$ppoffset,$pnoffset;
				if (!isset($_GET['offset']) || !preg_match('/^[0-9]+$/',$_GET['offset']))
					$offset = 0;
				else
					$offset = $_GET['offset'];
				
				@$rowsfound = $this->num_rows($sql);
				
				//move to disired offset
				$sql .= " LIMIT $offset, $prows ";
					
				//query
				//$result = mysqli_query($this->link, $sql);
				$this->result = $this->db->query($sql);

				// move to required internal counter
				//if ($rowsfound != 0)
					//@mysql_data_seek($result,$offset);
				
				$rows = $prows;
				
				if ($rowsfound < $rows)
					$rows = $rowsfound;
				
				$noffset = $offset+$rows;
				$poffset = $offset-$rows;
			
				// get the values for printing browse location
				$ppoffset = $offset + 1;
					
				if ($noffset > $rowsfound)
					$pnoffset = $rowsfound;
				else
					$pnoffset = $noffset;
				//echo "viewing ".$ppoffset." - ".$pnoffset." of ".$rowsfound;
			} 

			
		}
		
		
		// function to delete rows where values for deletion are in post variables
		var $folders; // array containing all folders where file is stored
		var $file_column;
		function delete_rows($table,$field,$location,$label = "",$number = 40)
		{
				$j = 0;
				for($i = 0; $i < $number; $i++)
				{
					if(isset($_POST[$label.$i]))
					{
						$value = $_POST[$label.$i];
						// if record is attached to file... delete as well
						if(!empty($this->folders))
						{
							$sql = "select * from $table where $field = $value";
							$data = $this->fetch_data($sql);
							foreach ($this->folders as $key1 => $value1)
							{
								if(file_exists($_froot.$value1.'/'.$data[$this->file_column]) && !empty($data[$this->file_column]) )
									unlink($_froot.$value1.'/'.$data[$this->file_column]);
							}
						}
						
						//exit;
						$sql = "delete from $table where $field = '$value'";
						//echo $sql; exit;
						if($this->mode == 'mysql')
						{
							if(!mysqli_query($this->link, $sql))
								set_alert(0,'Could not delete record, problem accessing database',$location);
							$deleted = 1;
						}
						else if($this->mode == 'oracle')
						{
							$stid = OCIParse($this->conn, $sql);
							OCIExecute($stid);
							$deleted = 1;
						}
						$j++;
					}
				}
				$s = ($j > 1) ? 's' : ''; 
				if(isset($deleted) && !empty($location) )
					if(!empty($location))
						set_alert(1,"Record$s deleted",$location); 
			
		}	

		function delete_a_row($table_name,$primary_key,$value,$location,$show_msg = true){
			
			if($this->mode == 'mysql'){
				
				if(!empty($this->folders))
				{
					$sql = "select * from $table_name where $primary_key = $value";
					$data = $this->fetch_data($sql);
					foreach($this->folders as $key1 => $value1)
					{
						if(file_exists($_froot.$value1.'/'.$data[$this->file_column])  && !empty($data[$this->file_column]))
							unlink($_froot.$value1.'/'.$data[$this->file_column]);
					}
				}
						
				$sql = "delete from $table_name where $primary_key = '$value'";
				$this->insert_data($sql,$location);
				if($show_msg)
					set_alert(1,'Record has been deleted',$location);
			}
		}	


		function create_select_box($data_field,$id,$name,$compare,$sql,$tabindex = "", $class = "basic", $jump_menu = FALSE)
		{
			
			$newvar = '_selected'.$name;
			global $data;
			$result = $this->prepare($sql,10000);
			echo '<select name = "'.$name.'" id = "'.$name.'" class = "'.$class.'"';
			
			if(!empty($tabindex))
				echo ' tabindex = "'.$tabindex.'" ';
			
			if($jump_menu)
				echo ' onchange="MM_jumpMenu(\'parent\',this,0)"  ';
			
			echo '>
					<option value = ""> -- Select one --</option>';
			if($jump_menu)
			{
				echo '<option value = "'.$this->page.'">Show All</option>';
				//echo '<option value = "'.$this->page.'&'.$name.'=e" '.selected($name,'e').' >Show Null Values</option>';
			}
			
			while($dat = $this->fetch_row($result))
			{
				
				echo '<option value = "';
				
				if($jump_menu)
					echo $this->page.'&'.$name.'=';
					
				echo $dat[$id].'"';
				
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
				{
					echo 'selected';
					unset($_SESSION[$name]);
				}
				echo '> '.ucfirst($dat[$data_field]).'</option>';
			}
			echo '</select>';
		}


		function browser($page)
		{
			echo '<div id = "page_browser" style = "margin-top:0px" >';
			global $rowsfound,$offset,$poffset,$noffset,$rows;
			//display first page
			if($offset > ($rows * 10))
				echo "\n \t <a href = '$page&offset=0'>&laquo; First Page</a> \n";
			
			
			if($offset>0) 
				echo "\n \t <a href='$page&offset=$poffset'>&laquo; previous</a>\n";
				
			if($offset <= $rows * 4)
			{
				$s = 0;
				$k = 1;
				$limit = $offset + ($rows * 10);
			}else{
				$s = $offset - ($rows * 5);
				$k = ($s / $rows) + 1;
				$limit = $offset + ($rows * 5);
			} 
			
		
			
			if ($rowsfound < $limit)
				$limit = $rowsfound;
			
			for ($f=$s,$p=$k; $f<$limit; $f+=$rows,$p++)
			{
				if ($f!=$offset)
					echo "<a href =\"$page&offset=$f\">[$p]</a>\n";
				else
					echo "[$p]\n";
			}
			
			if($noffset < $rowsfound)
				echo " &nbsp;<a href='$page&offset=$noffset'>next &raquo;</a>";
				
			// last page
				if (($rowsfound - $offset) > (10 * $rows))
				{
				
					$remainder = $rowsfound % $rows;
					
					if ($remainder == 0)
						$p = $rowsfound - $rows;
					else
					{
						$p = $rowsfound - $remainder;
						
					}
					
					echo "&nbsp; <a href = '$page&offset=$p'>Last Page</a>&nbsp;&raquo;";
				}
				
			echo "</div>";
		}


		// oracle aids for pagination
		function oracle_page($select, $start_row, $rows_per_page) {
	
			
		
		}
		
		

		

		
		
		function populate_sub_cat_javascript($table1,$column1,$column2,$table2,$column3,$column4,$checker)
		{
			// this sub cat function will work only 3 rows deep.....
			echo '<script language="JavaScript" type="text/javascript">
				var regionState = new DynamicOptionList();
				regionState.addDependentFields("'.$column2.'","'.$column4.'");
				regionState.forValue("").addOptionsTextValue("- select category - ","");';
		
			global $data;
			$sql = " Select * from $table1 order by $column1 ";
			$result = $this->prepare($sql);
			while($dat = $this->fetch_row($result))
			{
				echo "regionState.forValue('".$dat[$column2]."').addOptionsTextValue(";
				$sql2 = "select * from $table2 where $column2 = '".$dat[$column2]."' order by $column3";
				$result2 = $this->prepare($sql2);
				$i = $this->num_rows($sql2);
				if (empty($i))
					echo "'- No $table2 - ',''";
				else{
					
					echo "' - Select one - ','',";
					while ($data2 = $this->fetch_row($result2))
					{
						echo "'".$data2[$column3]."','".$data2[$column4]."'";
						if ($i != 1)
							echo ',';
						$i--;
					}
				}
				
				echo ");\n";
			}
			
			if (isset($data[$checker]))
				echo 'regionState.forValue("'.$data[$column2].'").setDefaultOptions("'.$data[$checker].'");';
			echo '</script>';
		}
		
		
		function select_pri_image($id,$type = 1)
		{
		
			$sql = "select * from vip_photos where vip_id = '$id' ";
			$data = $this->fetch_data($sql);
			
			if($type == 1)
				$pre = '<img class = "foto" src = "'.ROOT.'passports/';
			else if ($type == 2)
				$pre = '<img class = "foto" src = "'.ROOT.'member_images2/';
		
			if(!empty($data['filename']))
				return $pre.$data['filename'].'" />';
			else
				return '<img class = "foto" src = "'.ROOT.'images/noimage.gif" width = "100" length = "100" />';
						
		}



	
	}
	
	
	

?>