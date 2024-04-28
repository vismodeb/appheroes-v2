<?PHP

	//generic class to handle behaviour of lists managers..
	// this class helps us modularise code, and enable changing of code from one place.
	class list_handler extends db
	{
		
		var $table_name, $primary_key, $page;
		var $table_fields; // this should be an array where the first item is the name field for the list
		var $form_field_names; // this should be an array of the text to describe each form field. 
		var $form_field_length; // form field length contains the width of the columns, should be a two dimensional array to handle bothe field and name column
		var $text_field_length, $form_input_type; // array holdng length of form field... if text field that is.
		var $post_method, $form_table_width;
		var $captions; // list, add, edit, Singular name , Plural Name..
		
		var $display_table_heads, $display_table_widths; // array of all column heads in the display table
		var $display_table_elements;
		var $display_mode; // defines if displaying for parent table. normal table. or dependant table. or intermediary
		var $display_table_size; // describes the width of the table, could either be in % just integers
		var $display;
		var $dependant_page;
		var $control_id; // if dependant page this id will be necessary and it will be used to determine the parent table of this table
		var $parent_primary_key;
		var $parent_table; 
		var $dependant_table;
		var $parent_name, $parent_name_field, $parent_page, $parent_; // value of parent record handling this list!!
		var $sql;
		var $inside_loop;
		var $type;
		var $debug_post; // variables to help debug sql statements
		var $no_form;
		var $debug_sql;
		var $form_location;
		var $add_button;
		var $edit_row, $activation ;
		var $rows, $pre_form, $extra_buttons, $deletion_folders, $file_column;
		var $button_functions, $button_functions_fields, $button_functions_names, $button_functions_status, $button_functions_column_heads, $button_functions_function;
		var $table_fields_ext;
		var $goto_buttons, $goto_link, $display_table_only, $show_browser, $delete_method, $delete_loading_div, $my_form;
		var $switch_function, $search_form, $custom_search_form, $custom_searching, $show_checkbox, $show_del_button, $print_page, $for_print;
		var $edit_mode, $search_form_button;
		var $totals_elements;
		var $show_page_desc;
		var $left_menu;
		var $excel_file_name;
		var $excel_data_fn, $excel_load_fn, $overide_excel_load_fn, $excel_create_fn;
		var $excel_load_elements;
		var $excel_import_button, $csv_import_button, $excel_export_button, $pdf_export_button, $data_buttons, $show_excel_btn;
		var $graph;
		
		function __construct($database = DATABASE)
		{
			$this->type = 'recursive';
			$this->mode = RDBMS;
			$this->display_mode = '';
			$this->display_table_size = '50%';
			parent::__construct($database);
			$this->no_form = false;
			$this->debug_sql = false;
			$this->add_button = true;
			$this->edit_row = true;
			$this->display_table_only = FALSE;
			$this->activation = false;
			$this->rows = 20;
			//$this->display_mode = $display_mode;
			$this->show_browser = TRUE;
			$this->search_form = TRUE;
			$this->show_print_stub = FALSE;
			$this->show_checkbox = TRUE;
			$this->show_del_button = TRUE;
			$this->search_form_button = FALSE;
			$this->show_page_desc = true;
			$this->for_print = false;
			$this->show_excel_btn = false;
			$this->button_functions = array();
			$this->goto_buttons = array();
		}
		
		function print_stub()
		{
			global $_search_url;
			echo '<div id = "print_stub" title = "Print" class = "basic"><a class = "button_effect" href = "javascript:;" onclick = "popup(\''.ROOT.$this->print_page.$_search_url.'\',\'printwindow\')" ><img src = "'.ROOT.'images/printer.png" width = "24px" height ="24px" /></a></div>';
		}
		
		function access_controller()
		{
			// this function helps check agains url mishaps... in a case where a user has no access and he tries to url to a no-access action
			global $_access_level;
			if(!empty($_access_level) && $_access_level < 2 )
			{
				header('location:'.ROOT.'dashboard.php');
				exit;
			}
		}
	
		function post_handler()
		{
			global $_access_level, $data;
			
			
			// this handles button functions..
			// button functions are table events mapped to post button on form
			// this events are binary operations changing a field from 1 to 0 and back
			// this is used in cases where you making / unmaking a featured record or stuff similar to this..
			// (c) copyrights DCO consultants..
		
			if(!empty($this->table_fields_ext))
				foreach($this->table_fields_ext as $key => $value)
					$_POST[$key] = $value;
			
			for($j = 0; $j < count($this->button_functions); $j++ )
			{
				if(isset($_POST[$this->button_functions[$j]]))
				{
					$this->access_controller();
					
					for($i = 0; $i < $this->rows; $i++)
					{
						if(isset($_POST['ids'.$i]))
						{
							//check previous activation status
							$sql = "select * from {$this->table_name} where {$this->primary_key} = '".$_POST['ids'.$i]."' ";
							//echo $sql; exit;
							$data = $this->fetch_data($sql);
							
							if(!empty($this->button_functions_function[$j]))
							{
								$myfunc = $this->button_functions_function[$j];
								$myfunc();
							}
							else
							{
								if($data[$this->button_functions_fields[$j]] == 1)
									$new_status = 0;
								else
									$new_status = 1;
								$sql = "update {$this->table_name} set {$this->button_functions_fields[$j]} = '$new_status' where {$this->primary_key} = '".$_POST['ids'.$i]."' ";
								$this->insert_data($sql);
							}
						}
					}


					// run extra function
					if(!empty($myfunc))
						$myfunc($data,$this->button_functions[$j]);
					//set_alert(1,'Your changes have been saved',$this->page.'&control_id='.$_POST['control_id'].'&offset='.$_GET['offset']);
					set_alert(1,'Your changes have been saved', $_SERVER['HTTP_REFERER']);
				}
			}
			
			// handle deletion of records.		
			if (isset($_POST['del']))
			{
				$this->access_controller();
				
				// Bar Level one from deleting..
				if(!empty($_access_level) && $_access_level < 2)
				{
					
				}
				
				//print_r($_POST); exit;
				$j = 0;
				for($i = 0; $i < $this->rows; $i++)
				{
					if(isset($_POST['ids'.$i]))
					{
						//before deletion what if this record is linked to another table and its existence is key for the relevance of rows it relates to in other table..
						// so we check for relation,, and if one exists we stop deletion...
						if(!empty($this->dependant_table))
						{
							$sql = "select * from {$this->dependant_table} where {$this->primary_key} = '".$_POST['ids'.$i]."' ";
							if ( $this->num_rows($sql) > 0)
								set_alert(0,'Deletion cancelled because one of the records you selected needs to remain to maintain table relation, Delete Subs underneath it or remove any relation to it first before deletion can occur',$this->page.'&offset='.$_GET['offset'].'&control_id='.$_GET['control_id']);
						}
					
						$value = $_POST['ids'.$i];
						// if record is attached to file... delete as well
						if(!empty($this->deletion_folders))
						{
							$sql = "select * from {$this->table_name} where {$this->primary_key} = $value";
							$data = $this->fetch_data($sql);
							foreach ($this->deletion_folders as $key1 => $value1)
							{
								unlink($_froot.$value1.'/'.$data[$this->file_column]);
							}
						}
						
						//exit;
						$sql = "delete from {$this->table_name} where {$this->primary_key} = '$value'";
						if(!$this->insert_data($sql))
								set_alert(0,'Could not delete record, problem accessing database',$this->page.'&offset='.$_GET['offset']);
						$deleted = 1;
						
						$j++;
					}
				}
				$s = ($j > 1) ? 's' : ''; 
				$have = ($j > 1) ? 'have' : 'has';
				if(isset($deleted))
					set_alert(0,"Record$s $have successfully been deleted",$this->page.'&control_id='.$_GET['control_id'].'&offset='.$_GET['offset']); 

			}
			
			// handle updating of records
			if (isset($_POST['add_record']))
			{
				$this->access_controller();
				
				$_POST['control_id'] = (isset($_POST['control_id'])) ? $_POST['control_id'] : '';

				// this handles any action needed to be performed on data before submission.
				// depending on the table.
				if(empty($this->handle_post))
					$this->handle_post();
				else
				{
					$func = $this->handle_post;
					$func();
				}
				
					
				// add a following zero to all post variables, to handle single post on 1st loop.	
				if(!isset($_POST['num']))
				{
					$_POST['num'] = 1;
					for($i = 0; $i < count($this->table_fields); $i++)
						$_POST[$this->table_fields[$i].'0'] = $_POST[$this->table_fields[$i]];
				}
				
				
				auto_addslashes();
				if ($_POST['mode'] == 'edit')
				{
					$id = $_POST['id'];
					$sql = "update {$this->table_name} set ";
					
					for($i = 0; $i < count($this->table_fields); $i++)
					{
						$sql .= $this->table_fields[$i]." = '".$_POST[$this->table_fields[$i].'0']."' ";
						if(count($this->table_fields) - $i != 1)
							$sql .= ", ";
					}
					$sql .= " where {$this->primary_key} = '$id' ";
					
					if($this->debug_post)
					{
						echo $sql; 
						exit;
					}
					
					$this->insert_data($sql,$this->page.'&mode=edit&step=2&action=add&id='.$id.'&control_id='.$_POST['control_id']);
					set_alert(1,'Record has successfully been updated',$this->page.'&control_id='.$_POST['control_id']);
				}
				
				if($_POST['mode'] == 'bulk')
				{
					$delimiter = $_POST['delimiter'];
					if($delimiter == 'comma')
						$delimiter = ',';
					else if ($delimiter == 'tab')
						$delimiter = "\t";
					else if ($delimiter == 'new_line')
						$delimiter = "\n";
					//echo $_POST['delimiter'];	
					$sql = " insert into {$this->table_name} ( {$this->table_fields[0]}";
					
					if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary')
						$sql .= ", {$this->parent_primary_key} ";
					
					$sql .= " ) values ";
					
					$post_items = explode($delimiter,$_POST[$this->table_fields[0]]);
					
					for($i = 0; $i < count($post_items); $i++)
					{
						$sql .= ' ( "'.trim($post_items[$i]).'"  ';
						if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary')
							$sql .= ", '{$_POST['control_id']}' ";
						$sql .= " ), ";
					}
					
					$sql = rtrim($sql,', ');
					if($this->debug_post == true)
					{
						echo $sql;
						exit;
					}
					
					$this->insert_data($sql,$this->page.'&action=add&step=3&control_id='.$_POST['control_id']);
					set_alert(1,'Items have successfully been added to the database', $this->page.'&action=list&control_id='.$_POST['control_id']);
				}
				
				
				// handle addition of new records.
				for($j = 0; $j < $_POST['num']; $j++)
				{
					if(empty($_POST[$this->table_fields[0].$j]))
						continue;
								
					$sql = "insert into {$this->table_name} ( ";
							
					for($i = 0; $i < count($this->table_fields); $i++)
					{
						$sql .=  $this->table_fields[$i] ;
						if(count($this->table_fields) - $i != 1 )
							$sql .= ", ";
					}
					if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary' )
						$sql .= ", {$this->parent_primary_key} ";
					$sql .= " ) values ( ";
					for($i = 0; $i < count($this->table_fields); $i++)
					{
						$sql .=  "'".$_POST[$this->table_fields[$i].$j]."'" ;
						if(count($this->table_fields) - $i != 1)
							$sql .= ", ";
					}
					if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary' )
						$sql .= " ,'{$_POST['control_id']}' ";
					$sql .= " )";
					
					if($this->debug_post){
						echo $sql;
						exit; 
					}
					$this->insert_data($sql,$this->page.'&control_id='.$_POST['control_id'].'&action=add');
				}
						
					set_alert(1,'New entries have been stored',$this->page.'&action=list&control_id='.$_POST['control_id']);
			}
			
			if (isset($_POST['load_excel_file'])){
				$this->excel_load();
			}
			
			if(isset($_POST['load_txt_file'])){
				$this->txt_load();	
			}
		}
		
		
		function display()
		{
			global $offset,$result,$rowsfound,$rows,$noffset,$poffset,$ppoffset,$pnoffset,$data,$step,$mode;
			global $switch_function;
			global $_access_level;
			
			// make sure control_id is set for dependant and intermediary pages..
			if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary' )
			{
				if( !isset($_GET['control_id']) || empty($_GET['control_id']) )
					exit('<div style = "padding:15px">You may have tampered with the url for this page, please click the back button on your browser and start all over!</div>');
				else
					$this->control_id = $_GET['control_id'];
			}
			
			// if dependant list / table concatenate this
			if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary')
			{
				$sql = "select * from {$this->parent_table} where {$this->parent_primary_key} = '{$this->control_id}'";
				$data = $this->fetch_data($sql);
				$this->parent_name = $data[$this->parent_name_field];
				for($i = 0; $i < count($this->captions); $i++)
					$this->captions[$i] .= " under <b>".$this->parent_name."</b>";
			}
			
			//p_alert();
			$action = (isset($_GET['action'])) ? $_GET['action'] : '';
			$step = (isset($_GET['step'])) ? $_GET['step'] : 1;
			switch($action)
			{
				case 'add':
					
					// if Level one user cannot view Add / Edit form
					if(!empty($_access_level) && $_access_level < 2 )
						set_alert(2,'You do not have access to this area',$this->page,false,'jscript');
					
					if(!$this->no_form)
					{
						$mode = (isset($_GET['mode'])) ? $_GET['mode'] : '';
						$offset = (isset($_GET['offset'])) ? $_GET['offset'] : 0;
						
						if ($mode == 'edit')
						{
							$sql = "select * from {$this->table_name} where {$this->primary_key} = '{$_GET['id']}'";
							$data = $this->fetch_data($sql);
							//echo $sql;
							$this->switch_loop();
						}
						
						?>
						<div class="right_cont">
							<div class="title">
							<?PHP 
							//echo 'Home &raquo <span class=""> Back to '.$this->captions[4].'</a></span>';
							
							if($mode == 'edit')
								echo ''.$this->captions[2];
							else
								echo ''.$this->captions[1];
							
							?></div>
                            <div class="back_to"><a href="<?PHP echo $this->page ?>&action=list&offset=<?PHP echo $offset ?>&control_id=<?PHP echo $this->control_id ?>">Back To <?PHP echo $this->captions[4] ?></a></div>
							
                            
                            <div class="body1">
                            	<?PHP p_alert(); ?>
								<div class="add" id="div">
                                </div>
								<?PHP $this->switch_post_form(); ?> 
							</div>
                       
                        
						
                        </div>
						<div class="clear"></div>
                        <?PHP
					}
					
				break;
				
				
				
				
				
				
				
				
				
				
				default:
						
						$this->display_list();	
							
				break;
				
			}
		}
		
		function display_list()
		{
				global $offset,$result,$rowsfound,$rows,$noffset,$poffset,$ppoffset,$pnoffset,$data,$step,$mode;
				global $switch_function, $_search_url;
				global $_access_level;

					if(empty($this->sql))
					{
						$sql = " select * from {$this->table_name} ";
						if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary')
							$sql .= " where {$this->parent_primary_key} = '{$this->control_id}' ";
						if(isset($_GET['search'])) 
							$search = $_GET['search'];
						else if(isset($_POST['search']))
							$search = $_POST['search'];
						else
							$search = '';
						if(!empty($search))
						{	
							// concatenate search part of SQL
							$search_items = explode(' ',$search);
							$post_sql = "";
							if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary')
							{
								$sql .= " and ( ";
								$post_sql = " ) ";
								$k = true;
							}
							foreach ( $search_items as $key => $value )
							{
								if(strlen($value) == 1 || empty($value))	
									continue;
								if(isset($j))
									$sql .= " or ";
								else if (!isset($k))
									$sql .= " where ";
								$sql .= " ".$this->display_table_elements[0]." like '%$value%' ";
								$j = 1;
							}
							$sql .= $post_sql;
						}
						$sql .= " order by ".$this->display_table_elements[0];
					}
					else
					{
						$search = "";
						$sql = $this->sql;
						if(!empty($this->custom_searching))
						{
							$custom_searching = $this->custom_searching;
							$sql .= $custom_searching();
						}
					}
					
					//echo $sql;
					if($this->debug_sql)
						echo $sql;


					
					/** If Generating Data to EXcel or PDF **/
					if(isset($_GET['convExcel5'])){
						$this->excel_creator($this->excel_file_name);
						exit;
					}
					
					if(isset($_GET['convPDF'])){
						$this->excel_creator($this->excel_file_name, 'PDF');
					}
					
					$this->select_in_sets($sql,$this->rows);
					
					
					// echo page description....
					$record_end = ($noffset < $rowsfound) ? $noffset : $rowsfound ;
					if($rowsfound == 0)
						$page_description =  '';
					else
						$page_description = $offset + 1 . ' - ' . $record_end . ' of ';
					$page_description =  $page_description.$rowsfound . ' Records';

                    if(empty($this->form_location))
                        $this->form_location = $this->page.'&action=add&control_id='.$this->control_id;
					
					if(!$this->display_table_only)
					{

						
						echo '<div class="right_cont" >
							  <div class="title">';
						if($this->show_print_stub)
							$this->print_stub();
						
						echo $this->captions[0];
						
						echo '<div class="back_link">';
						$this->back_to_parent();
						echo '</div>';
						echo '</div>';


						if(!empty($this->pre_form))
							echo $this->pre_form;
						
						// Display Left menu if set..
						$right_cont = 'right_cont';
						/*
						if(!empty($this->left_menu)){
							echo '<div class="left_cont"> 
								  	'.$this->left_menu.'
								  </div>';
							$right_cont = 'right_cont';	
						}*/
						
						echo '<div class=""> ';
						echo '<div class="body1">';
						p_alert();
						
						if(empty($this->custom_search_form))
						{
							echo '<div id = "search_box">
									<form action = "" method = "POST" >
										<table width = "'.$this->display_table_size.'" border = "0" cellpadding = "0">
											<tr>
												<td>
													<span class = "basic">Search</span> <input class = "searchbox" type = "text" name = "search" value = "';
							
							if(isset($_POST['search']))
								echo $_POST['search'];
							
							echo '" />
													<!-- <input class = "mybutton2" type = "submit" class = "basic" value = "Search" name = "submit_button" /> -->
												</td>
											</tr>
										</table>
									</form>
								  </div>';
						}
						else 
						{
							echo '<div id="search_box" >';
							$custom_search_form = $this->custom_search_form;
							$custom_search_form();
							if($this->search_form_button)
								echo '<div class="basic" style="padding:10px 10px 0px 10px"><img src="'.ROOT.'/images/search.gif" width="11" height="11" /> <a href = "javascript:;" onclick="showhide(\'search_box\')">&nbsp;Show / Hide Search Form </a></div>';
							echo '</div>';
						}
						
						
						echo '<div class="add" id="add" >';
							
						if($this->add_button)
						{
							// display add button if admin level is 2 or 3
							if(!empty($_access_level) && $_access_level >= 2)
							{
								echo '<span class=""><a href="'.$this->form_location.'" class="add_btn">Add New '.$this->captions[3].'</a></span>';
								//if(count($this->table_fields) == 1)
									//echo ' <img src="'.ROOT.'ipanel/images/plus.gif" width="11" height="11" align="absmiddle" /> <span class="basic"><a href="'.$this->form_location.'&step=3">Add By Bulk</a></span>';
							}
							
							
						}
						
						if($this->show_excel_btn){
							$uri = $_SERVER['REQUEST_URI'];
							if(!strstr($uri, '?'))
								$uri .= '?';
							echo '<span class="basic"> <a href="'.$uri.'&convExcel5" class="excel_btn"> Download Excel format </a></span>';
						}
						echo '</div>';
						
							
						
						//echo '';
						
					}
					
					echo '<div style = "position:relative; width:'.$this->display_table_size.'"><div class = "table_loc_desc">'.$page_description.'</div></div>';
					
					echo '<div class="display_list">
						  <form id="display_list" name="display_list" method="post" action="'.$this->page.'&control_id='.$this->control_id.'&offset='.$offset.'"  onsubmit="return check_form(\'Are you sure you want to continue?\')">
						  <table width="'.$this->display_table_size.'" border="0" cellpadding="0" class="results" cellspacing="0" bordercolor="0">
							
							<tr>';
					
					// echo display table heads
					if($this->show_checkbox)
						echo '<td valign = "top" class="table_heads" width = "1%" ><div class ="th2">&nbsp;</div></td>';
					
					for($j = 0; $j < count($this->display_table_heads); $j++)
					{
						echo '<td class="table_heads" valign = "top" width = "'.$this->display_table_widths[$j].'"><div class ="th2">'.$this->display_table_heads[$j].'</div></td>';
					}
					
					for($j = 0; $j < count($this->button_functions); $j++)
						if(!empty($this->button_functions_column_heads[$j]))
							echo '<td valign = "top" class = "table_heads" width = "2%"><div class = "th2">'.$this->button_functions_column_heads[$j].'</div></td>';
					if($this->edit_row)
						echo '<td valign = "top" class="table_heads" width = "1%" ><div class ="th2">&nbsp;</div></td>';
					if($this->display_mode == 'parent' || $this->display_mode == 'intermediary')
						echo '<td valign = "top" class="table_heads" width = "1%" ><div class ="th2">&nbsp;</div></td>';
					for($j = 0; $j < count($this->goto_buttons); $j++)
						echo '<td valign = "top" class = "table_heads" width = "10%"><div class = "th2">&nbsp;</div></td>';
					
					
					if ($rowsfound == 0)
					{
						$cols = count($this->display_table_heads) + 2;
						if($this->display_mode == 'parent' || $this->display_mode == 'intermediary')
							$cols++;
						$cols = $cols + count($this->button_functions);
						echo '<tr><td colspan = "'.$cols.'" class = "table_td" > <span class = "basic">Sorry no search results returned</span></td></tr>';
					
					}
					$i=0;
					
					
					
					while (($data = $this->fetch_row()) && $i < $rows)
					{
						if($i % 2 == 1)
							echo '<tr bgcolor = "#f5f5f5">';
						else
							echo '<tr>';
						
						if($this->show_checkbox)
							echo '<td class = "table_td" width = "1%"><input id = "ids'.$i.'"  name="ids'.$i.'" type="checkbox" value="'.$data[$this->primary_key].'" /></td>';
						
						//computate sums..
						for($j = 0; $j < count($this->display_table_elements); $j++)
						{
							
						}
						
						//print_r($data);
						$this->switch_loop();
						if(!empty($this->switch_function))
						{
							$switch_function = $this->switch_function;
							$switch_function();
						}
						
						for($j = 0; $j < count($this->display_table_elements); $j++)
						{
							$style_align = isset($this->totals_elements) && in_array($this->display_table_elements[$j], $this->totals_elements) ? ' style = "text-align:right; display:block" ' : '';
								
							echo '<td class = "table_td" > <span '.$style_align.'> '.$data[$this->display_table_elements[$j]] .'</span> ' ;
							if( ($this->display_mode == 'parent' || $this->display_mode == 'intermediary') && $j == 0)
							{
								$sql = "select * from {$this->dependant_table} where {$this->primary_key} = '".$data[$this->primary_key]."'";
								echo " <span class = 'v10'>( ".$this->num_rows($sql)." subs )</span>";
							}
							echo '</td>';
							
							// if summation field.. create total summation variable and add to it.
							if(!empty($this->totals_elements))
							{
								if(in_array($this->display_table_elements[$j],$this->totals_elements))
								{
									if(!isset($totals_values[$j]))
										$totals_values[$j] = 0;
									$current_value = str_replace(',','',$data[$this->display_table_elements[$j]]);
									$totals_values[$j] += $current_value;
									//echo $totals_values[$j].'<br/>';
								}
							}	
							
						}
						
						
						for($j = 0; $j < count($this->button_functions); $j++)
						{
							if(!empty($this->button_functions_column_heads[$j]))
							{
								if($data[$this->button_functions_fields[$j]] == 1)
									//$status = $this->button_functions_status[$j][1];
									$status = '<img src = "'.ROOT.'images/accept.png" />';
								else
									//$status = '<span style = "color:#FF0000" class = "basic" >'.$this->button_functions_status[$j][0].'</span>';
									$status = ' -- ';
								echo '<td class = "table_td">'.$status.'</td>';
							}
						}
						
						
						if($this->edit_row)
						{
							echo '<td class = "table_td">';
							// Show Edit button if level 2 or 3
							if(!empty($_access_level) && $_access_level >= 2)
							{
								if($this->edit_mode == 'jscript')
									echo '<a title = "Edit Record" href = "javascript:;" onclick = "edit_emp_subdata(\''.$data[$this->primary_key].'\')" ><img title = "Edit Record" src = "'.ROOT.'images/edit_icon.png" width = "16" height = "16" /></a>';
								else
									echo '<a class = "del_button" href = "'.$this->form_location.'&step=2&mode=edit&offset='.$offset.'&id='.$data[$this->primary_key].'" ><img  title = "Edit Record" src = "'.ROOT.'images/edit_icon.png" width = "16" height = "16" /></a>';
							}
							echo '</td>';
						}
						
						if($this->display_mode == 'parent' || $this->display_mode == 'intermediary' )
							echo '<td class = "table_td"><a class = "del_button" href = "'.$this->dependant_page.'&control_id='.$data[$this->primary_key].'"> <img  src = "'.ROOT.'images/manage_subs.png" width = "16" height = "16" title = "Manage subs" /></a></td>';
							
						for($j = 0; $j < count($this->goto_buttons); $j++)
						{
							echo '<td class = "table_td"><a href = "'.$this->goto_link[$j].'&id='.$data[$this->primary_key].'&offset='.$offset.'">'.$this->goto_buttons[$j].'</a></td>';
						}
						
						echo '</tr>';	
						$i++;
						
					}
					
					// Display totals Row..
					if(isset($totals_values))
					{
						$u=0;
						for($j=0; $j<count($this->display_table_elements); $j++)
							if(!isset($totals_values[$j]))
								$u++;
							else
								break;
						
						if($this->for_print)
							$colspan = $u;
						else
							$colspan = $u+1;
						echo '<tr class="totals_row"> <td class = "table_td" colspan = "'.$colspan.'" ><b>Totals</b></td>';
						for($j=$u; $j < count($this->display_table_elements); $j++)
						{
							if(isset($totals_values[$j]))
								echo '<td class = "table_td"> <div style="text-align:right"> '.comma_value($totals_values[$j]).'</div> </td>';
							else
								echo '<td class = "table_td">&nbsp;</td>';
						}
						if($this->edit_row)
							echo '<td class="table_td"> </td>';
						echo '</tr>';
						
					}
					
					echo '</table> </div> <!-- End of Display_list container -->';
					
					if($this->show_browser == true)
					{
						echo '<div class="browser">';
						$this->browser($this->page.'&search='.$search.'&control_id='.$this->control_id);
						echo '</div>';
					}
					
					// Show delete button if level 2 or 3
					if(!empty($_access_level) && $_access_level >= 2)
					{
						echo '<div class = "del_button_area">';
						
						if($this->show_del_button)
						{
							if($this->delete_method == 'jscript')
								echo '<input type = "button" name = "del" id = "del" Value = "Delete" onclick = "delete_from_list(\'loader\')"  class = "list_del_button"  />';
							else
								echo '<input name="del" type="submit" id="cstat" value="Delete selected" class = "list_del_button" />';
						}	
						
						// echo button functions
						for($j = 0; $j < count($this->button_functions); $j++)
							echo '<input type = "submit" id = "'.$this->button_functions[$j].'" name = "'.$this->button_functions[$j].'" value = "'.$this->button_functions_names[$j].'" class = "list_del_button" />' ;
					
							
						echo '&nbsp;&nbsp; [ <a href="javascript:SetChecked(1)">check all</a> ]  [ <a href="javascript:SetChecked(0)">uncheck all</a> ]
								  </div>
									
									<div class="delete" id = "delete"> </div>
								';
						
					}
					
					
					
					
					echo ' </form>
							 </div>  <!-- End of body1 tag -->
							 </div>  <!--  -->
						  	 </div> <!-- End of Right container!!new -->
							<div class="clear"> </div>';
		}
		
		
		function txt_load(){
			
			$referer = $_SERVER['HTTP_REFERER'];
			
			if(empty($_FILES['txt_load']['size'])){
				set_alert(0, "Sorry no File uploaded", $referer);
			}
			
			if($_FILES['txt_load']['size'] > EXCEL_FILE_LOAD_LIMIT){ //Sorry file exceeds upload Limit..
				$file_limit = round(EXCEL_FILE_LOAD_LIMIT/1000000)." Mb";
				set_alert(0, "Sorry File size is greater than limit: ".$file_limit, $referer);
			}
			
			$txt_mimes = array('text/plain');
			if(!in_array($_FILES['txt_load']['type'], $txt_mimes))
				set_alert(0, "Sorry this file type is not supported. Upload Text files only", $referer);
			
			$file_path = $_FILES['txt_load']['tmp_name'];
			
			
			
			if($this->display_mode == 'dependant' || $this->display_mode == 'intermidiary' )
				$control = ','.$this->parent_primary_key; 
			$sql = "insert into ".$this->table_name." ( ".implode(', ', $this->excel_load_elements).$control." ) values  " ;
			
			$resource = fopen($file_path, 'r');
			while(!feof($resource)){
				$file = fgets($resource);
				$items = explode(',', $file);
				$string = "( ";
				$valid = 0;
				
				for($j=0; $j < count($this->excel_load_elements); $j++){
					$value = $items[$j];
					if(!empty($value)) $valid = 1;
					$string .= " '".$value."', ";
				}
				
				if($this->display_mode == 'dependant' || $this->display_mode == 'intermidiary' )
						$string .= " '".$this->control_id."' ";
				$string = rtrim($string, ',')." ), ";
				
				if(empty($valid))
					continue;
					
				$sql .=  $string;
				$rowsadded++;
			}
			
			fclose($resource);
			$sql = rtrim($sql, ', ');
			$this->insert_data($sql);
			set_alert(1, 'Great! '.$rowsadded.' record(s) Imported!', $referer);
		}
		
		function excel_load(){
			//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			//$objReader->setReadDataOnly(true);
			//$objPHPExcel = $objReader->load("test.xlsx");
			$referer = $_SERVER['HTTP_REFERER'];
			
			if(empty($_FILES['excel_load']['size'])){
				set_alert(0, "Sorry no File uploaded", $referer);
			}
			
			if($_FILES['excel_load']['size'] > EXCEL_FILE_LOAD_LIMIT){ //Sorry file exceeds upload Limit..
				$file_limit = round(EXCEL_FILE_LOAD_LIMIT/1000000)." Mb";
				set_alert(0, "Sorry File size is greater than limit: ".$file_limit, $referer);
			}
			
			$excel_mimes = array('application/excel', 'application/x-excel', 'application/x-msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			if(!in_array($_FILES['excel_load']['type'], $excel_mimes))
				set_alert(0, "Sorry this file type is not supported. Upload Excel files only", $referer);
			
			$file_path = $_FILES['excel_load']['tmp_name'];
			 		
			$objPHPExcel = PHPExcel_IOFactory::load($file_path);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$rows = $objWorksheet->getHighestRow(); // e.g. 10
			//$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
			//$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
			$control = '';
			if($this->display_mode == 'dependant' || $this->display_mode == 'intermidiary' )
				$control = ','.$this->parent_primary_key; 
			
			if(!empty($this->overide_excel_load_fn)){
				$fn = $this->overide_excel_load_fn;
				$fn($objWorksheet, $this);
			}
			
			$sql = "insert into ".$this->table_name." ( ".implode(', ', $this->excel_load_elements).$control." ) values  " ;
			$rowsadded = 0;
			for($i=1; $i<= $rows; $i++){
				
				$string = "( ";
				$valid = 0;
				
				for($j=0; $j < count($this->excel_load_elements); $j++){
					$value = addslashes($objWorksheet->getCellByColumnAndRow($j, $i)->getValue());
					
					if(!empty($value))
						$valid=1;
					$string .= " '".$value."', ";
					if(!empty($this->excel_load_fn)){
						$fn = $this->excel_load_fn;
						$fn($objWorksheet, $i); // pass ExcelObj and row number..
					}
				}
				
				/*$c = count($this->excel_load_elements) + count($this->excel_load_elements_ext);
				for($j=count($this->excel_load_elements); $j<$c; $j++){
					if(isset($this->excel_load_elements_ext[$j])){
							
					}
				}*/
				
				//for($j=
				
				if($this->display_mode == 'dependant' || $this->display_mode == 'intermidiary' )
						$string .= " '".$this->control_id."' ";
				$string = rtrim($string, ',')." ), ";
				
				if(empty($valid))
					continue;
					
				$sql .=  $string;
				$rowsadded++;
				
				
				
			}
			$sql = rtrim($sql, ', ');
			//echo $sql; exit;
			$this->insert_data($sql);
			set_alert(1, 'Great! '.$rowsadded.' record(s) Imported!', $referer);
		}
		
		
		function excel_creator($file_name, $type = "Excel5")
		{
			global $data, $j, $_name;
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			// Set properties
			$objPHPExcel->getProperties()->setCreator($this->captions[1] .':'. $_name);
			$objPHPExcel->getProperties()->setLastModifiedBy($this->captions[1] .':'. $_name);
			
			// Create Titles..
			for($i=0; $i < count($this->display_table_heads); $i++)
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i, 1, ucfirst($this->display_table_heads[$i]));
		
			$result = $this->prepare($this->sql);
			//echo 'SQL:'.$this->sql;
		
			$j = 2;
			while ($data = $this->fetch_row($result))
			{
				// perform data function here..
				if(!empty($this->excel_create_fn)){
						$fn = $this->excel_create_fn;
						$fn();
						
				}
				
				for($i=0; $i < count($this->display_table_elements); $i++){
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i,$j, $data[$this->display_table_elements[$i]]);
				}
				$j++;
				
				// limit Excel to max of 30000 records
				if($j == 30000)
					break;
			}
			// Rename sheet
			//$objPHPExcel->getActiveSheet()->setTitle('Call Manager Report');
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			
			// Redirect output to a client’s web browser (Excel5)
			$mime_type = $type == 'Excel5' ? 'application/vnd.ms-excel' : 'application/pdf';
			$ext = $type == 'Excel5' ? '.xls' : '.pdf';
			
			header('Content-Type: '.$mime_type);
			header('Content-Disposition: attachment;filename="'.$file_name.$ext);
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $type); // type:: Excel5, PDF
			$objWriter->save('php://output'); 
			exit;
		}
		
		var $parent_parent_key;
		function back_to_parent()
		{
			global $offset;
			if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary')
			{
				// if itermediar we need the control_id for the list page..
				$sql = "select * from {$this->parent_table} where {$this->parent_primary_key} = '{$this->control_id}' ";
				//echo $sql;
				$data = $this->fetch_data($sql);
				$control_id = $data[$this->parent_primary_key];
				echo '<span class=""><a href="'.$this->parent_page.'&action=list&offset='.$offset.'&control_id='.$control_id.'">  Back to '.$this->parent_.'  </a></span>';
			}
		}
		
		function switch_loop()
		{
			global $data,$hours,$mins;
			switch($this->type)
			{
				case 'companies':
					
					$sql = "select * from states where state_id = '{$data['state_id']}'";
					$d = $this->fetch_data($sql);
					$data['state'] = $d['state'];
					
				break;
				
				
				case 'lunch':
					if($data['type'] == 1)
						$data['duration'] = parseSeconds($data['resume_time'])." -- ".parseSeconds($data['close_time']);
					else
						$data['duration'] = $data['shift_duration']." mns";
				
				break;
				
				
				
				case 'users':
					$data['name'] = ucfirst($data['name']);
					/*
					if($data['access_level'] == 1)
						$data['access_level'] = 'Level 1';
					else if($data['access_level'] == 2)
						$data['access_level'] = 'Level 2';
					else if($data['access_level'] == 3)
						$data['access_level'] = 'Level 3';*/
				break;
				
			}
		}
		
		function switch_post_form()
		{
			global $step,$mode,$data;
					
					if(!empty($this->my_form))
					{
						$post_func = $this->my_form;
						$post_func();
					}
					else if($this->type == 'recursive')
					{
						$page = (isset($_GET['page'])) ? $_GET['page'] : '';
						if($step == 1)
						{
							?>
                            <div class="setup_form">
                            	<div class = "setup_form_header">Number of Fields to Add</div>
								<form action="<?PHP echo $this->page ?>&step=2&amp;action=add&control_id=<?php $this->control_id ?>" method="get" name="form1" id="form1">
								<table width="600" border="0" cellspacing="0" cellpadding="4">
								  <tr>
									<td width="10%" class="basic">Select</td>
									<td width="90%"><?php select_box_10('number_fields') ?>
									  <input name="action" type="hidden" id="action" value="add" />
									  <input name="step" type="hidden" id="step" value="2" />
									  <input name="page" type="hidden" id="page" value="<?PHP echo $page ?>" /></td>
									  <?PHP
									  
									  if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary')
									  	echo '<input name = "control_id" type = "hidden" value = "'.$this->control_id.'" /> ';
									  
									  ?>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td><input class="mybutton" type="submit" name="Submit2" value="Submit" /></td>
								  </tr>
								</table>
							  </form>
                            </div>
							<?PHP
						}
						else if($step == 2)
						{
							if (!isset($_GET['number_fields']))
								$_GET['number_fields'] = 1;
							?>	
                            
                            <div class  = "setup_form" style="width:660px">
                            	<div class="setup_form_header" >Define List Fields</div>
                            
							<form action="<?PHP echo $this->page ?>&control_id=<?php echo $this->control_id ?>" method="post" enctype="" name="form1" id="form1" onsubmit="return validateForm()">
								<input type="hidden" name="add_record" value="1" />
								  <table width="<?php echo $this->form_table_width; ?>" border="0" cellspacing="0" cellpadding="4">
	
								<?php 
								for ($i = 0; $i < $_GET['number_fields']; $i++)	
								{
									if(empty($this->form_input_type[$i]))
										$this->form_input_type[$i] = 'text';
									$l = $i+1;
									echo '<tr>';
									echo '<td class = "basic gray" width = "1%">'.$l.'. </td>';
									for($j = 0; $j < count($this->form_field_names); $j++)
									{
										
										echo '<td width="'.$this->form_field_length[$j][0].'" class="basic">'.$this->form_field_names[$j].'</td>
											  <td width="'.$this->form_field_length[$j][1].'" class="basic"><input class = "basic" name="'.$this->table_fields[$j].$i.'" type="'.$this->form_input_type[$i].'" id="'.$this->table_fields[$j].$i.'" value="';
										espost($this->table_fields[$j]);
										echo '" size = "'.$this->text_field_length[$j].'"/></td>';
									
									}
									echo '</tr>';
								}
								?>		
								<tr>
								  
								  <td colspan="3"><input class="mybutton" type="submit" name="Submit" value="Submit" />
								  
								  <input name="mode" type="hidden" id="mode" value="<?php echo $mode ?>" />
								  <input name="id" type="hidden" id="id" value="<?php espost($this->primary_key) ?>" />
								  <input name="num" type="hidden" id="num" value="<?php echo $_GET['number_fields'] ?>" />
								  <?PHP
								  if($this->display_mode == 'dependant' || $this->display_mode == 'intermediary' || $this->display_mode == 'parent' )
								  {
								  	echo '<input type = "hidden" name = "control_id" value = "'.$this->control_id.'" />';
								  }
								  
								  ?>
								  </td>
								</tr>
							  </table>
							</form>
                            </div>
                            
                            
                            
							<?PHP
						}
						else if ($step	== 3)
						{
							?>
                            
                            	<form action="<?PHP echo $this->page ?>&control_id=<?php echo $this->control_id ?>" method="post" enctype="" name="form1" id="form1" onsubmit="return validateForm()">
									<input type="hidden" name="add_record" value="1" />
								  		<table width="<?php echo $this->form_table_width; ?>" border="0" cellspacing="0" cellpadding="4">
                                        <?php 
										
												
												for($j = 0; $j < count($this->form_field_names); $j++)
												{
													echo '<tr>';
													echo '<td width="'.$this->form_field_length[$j][0].'" class="v11">'.$this->form_field_names[$j].'</td>
														  <td width="'.$this->form_field_length[$j][1].'" class="v11"><textarea name="'.$this->table_fields[$j].$j.'" id="'.$this->table_fields[$j].$j.'" cols="30" rows="4">';
													espost($this->table_fields[$j]);
													echo '</textarea></td>';
													echo '</tr>';
												}
										
										?>	
                                        	<tr>
                                            	<td class = "v11">Delimiter</td>
                                                <td>
                                                	<select name="delimiter">
                                                    	<option value = "comma">comma</option>
                                                        <option value = "tab">Tab</option>
                                                        <option value = "new_line">New Line</option>
                                                    </select>
                                                </td>
                                            </tr>	
                                            <tr>
                                      			<td>&nbsp;</td>
								  				<td>
                                                  
                                                  <input type="submit" name="Submit" value="Submit" />
                                                  <input name="mode" type="hidden" id="mode" value="bulk" />
                                                  <input name="id" type="hidden" id="id" value="<?php espost($this->primary_key) ?>" />
                                                  <input name="num" type="hidden" id="num" value="<?php echo $_GET['number_fields'] ?>" />
                                                  <input type = "hidden" name = "control_id" value = "<?PHP echo $this->control_id ?>" />
												</td>
											</tr>
							  			</table>
								</form>
                            <?PHP
							
						}
					}
					
					else if($this->type == 'users')
					{
						//print_r($data);
						$myjs = new jsclass();
						  $myjs->validate_fields = array('name','username','password1');
						  $myjs->validate_field_name = array('Staff Name','Username','Password');
						  $myjs->validate_form();
						?>
                        
                        <div class="form-cont">
                        <form id="form1" name="form1" method="post" action="" onsubmit="return validateForm()">
						  <table width="600" border="0" cellspacing="0" cellpadding="4">
							<tr>
							  <td class="form_label">Staff Name </td>
							  <td><input class="txtbox" name="name" type="text" id="name" value="<?php espost('name') ?>" /></td>
							</tr>
							<tr>
							  <td width="25%"  class="form_label">Username</td>
							  <td width="75%"><input class="txtbox" type="text" id="username" name="username" value="<?php espost('username') ?>" /></td>
							</tr>
							<tr>
							  <td  class="form_label">password</td>
							  <td><input class="txtbox" name="password1" type="password" id="password1" value="<?php espost('password') ?>" /></td>
							</tr>
                           
                            <!--
							<tr>
							  <td  class="basic">Re-enter password </td>
							  <td><input class="basic" name="password2" type="password" id="password2" value="" /></td>
							</tr>
                            -->
							
                            <tr>
							  <td  class="form_label">User Level </td>
							  <td>
                              <select  class="txtbox" name="access_level" id="access_level" >
							  	 <option value="1" <?php selected('access_level',1) ?> >Level 1</option>
								 <option value="2" <?php selected('access_level',2) ?> >Level 2</option>
                                 <option value="3" <?php selected('access_level',3) ?> >Level 3</option>
							  </select>          </td>
							</tr>
							<tr>
							  <td>&nbsp;</td>
							  <td><input class="mybutton" type="submit" name="Submit" value="Submit" />
							  <input name="mode" type="hidden" id="mode" value="<?php echo $mode ?>" />
							  <input name="id" type="hidden" id="id" value="<?php espost('user_id') ?>" />
							  <input name="add_record" type="hidden" value = "1"/>
                              <input name="user_status" type="hidden" value = "1"/>
							  </td>
							</tr>
						  </table>
						</form>
						</div>
                        
						<?PHP
					}
		
		}
		
		
		function handle_post()
		{
				// this handles any action needed to be performed on data before submission.
				// depending on the table.
				switch($this->type)
				{
					case 'shift':
					case 'lunch':
						$_POST['resume_time'] = ( $_POST['resume_time_hour'] * 60 * 60 ) + ($_POST['resume_time_min'] * 60 );
						$_POST['close_time'] = ( $_POST['close_time_hour'] * 60 * 60 ) + ($_POST['close_time_min'] * 60 );
					break;
					
					case 'users':
						$_POST['password'] = $_POST['password1'];
						
					break;
					
					
				}
		}

		
	}
	
	

?>