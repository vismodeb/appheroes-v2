<?PHP
// GENERIC CLASS WHICH HANDLES ALL POSTS FROM A FORM
// COPYRIGHTS DCO CONSULTANTS 2009 (C)
// BY OKECHUKWU NNAMDI 08058523427


class post_controller extends db
{
	
	var $table_name;
	var $primary_key;
	var $table_fields;
	var $table_fields_ext;
	var $success_page;
	var $failure_page;
	var $debug_post;
	var $success_msg;
	var $id;
	
	
	function post_handler()
	{
			// if we are extending the post vars
			// i.e when we want to add values not necessarily in the form
			if(!empty($this->table_fields_ext))
				foreach($this->table_fields_ext as $key => $value)
					$_POST[$key] = $value;
	
			// handle updating of records
			if (isset($_POST[$this->table_fields[0]]))
			{
				// this handles any action needed to be performed on data before submission.
				// depending on the table.
				$this->handle_post();
				auto_addslashes();
				if (isset($_POST['mode']) && $_POST['mode'] == 'edit')
				{
					if(empty($this->id))
						$this->id = $_POST['id'];
					
					$sql = "update {$this->table_name} set ";
					
					for($i = 0; $i < count($this->table_fields); $i++)
					{
						$sql .= $this->table_fields[$i]." = '".$_POST[$this->table_fields[$i]]."' ";
						if(count($this->table_fields) - $i != 1)
							$sql .= ", ";
					}
					$sql .= " where {$this->primary_key} = '{$this->id}' ";

					if($this->debug_post){
						echo $sql; exit;
					}
					$this->insert_data($sql,$this->failure_page);
					if(!empty($this->success_page))
						set_alert(1,'Record has successfully been updated',$this->success_page,false);
				}else
				{
				
				
					// handle addition of new records.
					$sql = "insert into {$this->table_name} ( ";
								
					for($i = 0; $i < count($this->table_fields); $i++)
					{
						$sql .=  $this->table_fields[$i] ;
						if(count($this->table_fields) - $i != 1 )
							$sql .= ", ";
					}
					$sql .= " ) values ( ";
					for($i = 0; $i < count($this->table_fields); $i++)
					{
						$sql .=  "'".$_POST[$this->table_fields[$i]]."'" ;
						if(count($this->table_fields) - $i != 1)
							$sql .= ", ";
					}
					$sql .= " )";
                    if($this->debug_post){
						echo $sql; exit;
					}
					$this->insert_data($sql,$this->failure_page);
					
					//echo $this->email_msg; exit;
					if(!empty($this->email_to))
						mail($this->email_to,$this->email_subject,$this->email_msg,'From:info@damzeeweddings.com');
					
					if(!empty($this->success_page))
					{
						if(!empty($this->success_msg))
							set_alert(1,$this->success_msg,$this->success_page,false);
						if(!empty($this->success_page))
						{
							header('location:'.$this->success_page);
							exit;
						}
					}
				}		
			}
			
				
	}
	
	function handle_post()
	{
	
	}
	
	function activate_by_email($table_name,$status_identifier)
	{
		if(isset($_GET['activate']))
		{
			if(!isset($_GET['k']) || !isset($_GET['i']))
			{
				header('location:register.php?page=a_error');
				exit;
			}
			$k = $_GET['k'];
			$i = $_GET['i'];
			$sql = "select * from $table_name where email = '$i'";
			$data = $this->fetch_data($sql);
			
			if(empty($data))
			{
				header('location:register.php?page=a_error');
				exit;
			}
			
			if(crypt($data['first_name'],'dz') == $_GET['k'])
			{
				// activate account
				$sql = "update $table_name set $status_identifier = 1 where email = '$i' ";
				$this->insert_data($sql,'register.php?page=a_error');
			}
			header('location:register.php?page=finished');
			exit;
		}
	}


}

?>