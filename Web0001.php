<?php 
class Web0001 extends CI_Controller{

// -------------------------------Grievance----------------------------------------------
    public function grievance(){
		if ($this->ion_auth->logged_in())
		{
			$this->load->view('includes/header');
			$this->load->view('includes/left_sidebar');
			$this->load->view('Test/grievance',$data);
			$this->load->view('includes/footer');
		}
		else {
			redirect('auth/login', 'refresh');
		}
	}
	
	public function hrgrievance(){
		if ($this->ion_auth->logged_in())
		{
			$this->load->view('includes/header');
			$this->load->view('includes/left_sidebar');
			$this->load->view('Test/hrgrievance',$data);
			$this->load->view('includes/footer');
		}
		else {
			redirect('auth/login', 'refresh');
		}
	}
    
    public function savegrieve(){
    	$uid = $this->session->userdata['user_id'];
    	$grivence = $_REQUEST['grivence'];
    	$category = $_REQUEST['category'];
    	$remark = $_REQUEST['remark'];
    	$documents = $_REQUEST['documents'];
    	$data['griev_id'] = "";
    	$data['griev_user'] =  $uid;
    	$data['griev_type'] =  $grivence;
		$data['griev_reas'] = $category;
		$data['griev_rem'] = $remark;
		$data['griev_doc'] = $documents;
		$data['griev_entrydt'] = date('Y-m-d H:i:s');
		$data['griev_status'] = 1;
		$this->Crud_model->insert_record('hr_grievance',$data);
		// echo $this->db->last_query();die;
		echo "data saved successfully";
    }
    
    public function fetchgrieve(){
		$advid = $_POST['advid'];
		$result = $this->Common_model->find_query("SELECT *  FROM `advocate_mst` WHERE `adv_id` = $advid");
		$adv_id = $result[0]['adv_id'];
		$adv_name = $result[0]['adv_name'];
		$adv_contact = $result[0]['adv_contact'];
		$json=array('adv_id' => $adv_id,'adv_name' => $adv_name,'adv_contact' => $adv_contact);
		echo json_encode($json);
	}
    
    public function searchgrieve(){
		$srchgrivence = $_REQUEST['srchgrivence'];
		$category2 = $_REQUEST['category2'];
		$condition = "";
		
		$userid=$this->session->userdata['user_id'];
		
		if(isset($_REQUEST['srchgrivence']) && $_REQUEST['srchgrivence']!=""){
			$condition.=" and griev_type = '".$_REQUEST['srchgrivence']."' ";
		}
		
		if(isset($_REQUEST['category2']) && $_REQUEST['category2']!=""){
			$condition.=" and griev_reas = '".$_REQUEST['category2']."' ";
		}
		
		$resultdata = $this->Common_model->find_query("SELECT * FROM `hr_grievance` WHERE griev_status = 1 and griev_user=$userid $condition");
		
		$sl=0;
	   	foreach($resultdata as $row){
	   	$sl++;
	      ?> 
		   	<tr>
			   	<td><?php echo $sl; ?></td>
			   	<td><?php $empid = $this->Common_model->findfield('users','id',$row['griev_user'],'emp_id');
			   	echo  $this->Common_model->findfield('hr_empmst','emp_id',$empid,'emp_name');
			   	// echo $this->db->last_query();die;
			   	?></td>
			   	<td><?php 
				   		if($row['griev_type'] == 1){
				   			echo "General";
				   		}else{
				   			echo "Confidential";	
				   		};
				   	?>
			   	</td>
			   	<td><?php
				   		switch ($row['griev_reas']){
				   			case 1:
				   				echo "Behaviour";
				   				break;
				   			case 2:
				   				echo "Salary";
				   				break;
				   			case 3:
				   				echo "Other Department";
				   				break;
				   			case 4:
				   				echo "Organization Policy";
				   				break;
				   			default:
				   				echo "Others";
				   		};
					?>
				</td>
			   	<td><?php echo $row['griev_doc']?></td>
			   	<td><?php echo $row['griev_rem'] ?></td>
			   	<td><?php echo $row['griev_hrrem'] ?></td>
			   	<td><?php
			   			if($row['griev_status'] == 1){
			   				echo "Pending";
			   			}else{
			   				echo "Accepted";
			   			};
			   		?>
			   	</td>
		   	</tr>
	   	<?php
	   }
    }
    
    public function srchhrgrieve(){
		$srchgrivence = $_REQUEST['srchgrivence'];
		$category2 = $_REQUEST['category2'];
		$condition = "";
		
		if(isset($_REQUEST['srchgrivence']) && $_REQUEST['srchgrivence']!=""){
			$condition.=" and griev_type = '".$_REQUEST['srchgrivence']."' ";
		}
		
		if(isset($_REQUEST['category2']) && $_REQUEST['category2']!=""){
			$condition.=" and griev_reas = '".$_REQUEST['category2']."' ";
		}
			
		$resultdata = $this->Common_model->find_query_all("SELECT * FROM `hr_grievance` WHERE griev_status = ? $condition", array(1));
		
		// echo $this->db->last_query(); die;
		$sl=0;
	   	foreach($resultdata as $row){
	   	$sl++;
	      ?> 
		   	<tr>
			   	<td><?php echo $sl; ?></td>
			   	<td><?php $empid = $this->Common_model->findfield('users','emp_id',$row['griev_user'],'emp_id');
			   	echo  $this->Common_model->findfield('hr_empmst','emp_id',$empid,'emp_name');
			   	// echo $this->db->last_query();die;
			   	?></td>
			   	<td><?php 
				   		if($row['griev_type'] == 1){
				   			echo "General";
				   		}else{
				   			echo "Confidential";	
				   		};
				   	?>
			   	</td>
			   	<td><?php
				   		switch ($row['griev_reas']){
				   			case 1:
				   				echo "Behaviour";
				   				break;
				   			case 2:
				   				echo "Salary";
				   				break;
				   			case 3:
				   				echo "Other Department";
				   				break;
				   			case 4:
				   				echo "Organization Policy";
				   				break;
				   			default:
				   				echo "Others";
				   		};
					?>
				</td>
			   	<td><?php echo $row['griev_doc']?></td>
			   	<td><?php echo $row['griev_rem']?></td>
			   	<td><?php echo $row['griev_hrrem'] ?></td>
			   	<td>
			   		<center>
							<button onclick="openmodal('<?php echo $row['griev_id']?>')" class="btn btn-warning btn-sm"> + ADD </button>
					</center>
				</td>
			   	<td><center><button class="btn btn-success btn-sm" onclick="forwordgrieve('<?php echo $row['griev_id']?>')">Forword</button></center></td>
		   	</tr>
	   	<?php
	   }
    }
    
    public function savehrgrieve(){
		$remark = $_REQUEST['remark'];
		$griev_id = $_REQUEST['id'];
		$data['griev_hrrem'] = $remark;
		$this->Crud_model->edit_record_by_any_id('hr_grievance','griev_id',$griev_id,$data);
		echo  "HR Remark Added Sucessfully";
	}
	
	public function forwordgrieve(){
		$griev_id = $_REQUEST['id'];
		$data['griev_status'] = 2;
		$this->Crud_model->edit_record_by_any_id('hr_grievance','griev_id',$griev_id,$data);
		echo  "Foworded Sucessfully";
	}
	
	public function catagory2(){
    	$catgory_id  = $_REQUEST['id'];
    	if($catgory_id == 1){
    		?>
				<option value="1">Behaviour</option>
				<option value="2">Salary</option>
				<option value="3">Other Department</option>
				<option value="4">Organization Policy</option>
				<option value="5">Others</option>
    		<?php
    	}
    	elseif($catgory_id == 2){
			?>
    		<option></option>
    		<?php
    	}
    	else{
    		?>
    		<option>Select Category</option>
    		<?php
    	}
    }
    
    public function catagory(){
    	$catgory_id  = $_REQUEST['id'];
    	if($catgory_id == 1){
    		?>
				<option value="1">Behaviour</option>
				<option value="2">Salary</option>
				<option value="3">Other Department</option>
				<option value="4">Organization Policy</option>
				<option value="5">Others</option>
    		<?php
    	}
    	elseif($catgory_id == 2){
			?>
    		<option></option>
    		<?php
    	}
    	else{
    		?>
    		<option>Select Category</option>
    		<?php
    	}
    }

}
