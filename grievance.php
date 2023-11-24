<!DOCTYPE html>
<html lang="en">
<head>
<style>
	.form-control1 {
		border-radius: 5px;
		height:38px; !important;
		border-color:#ffdca2;
	}
</style>
</head>
<body class="skin-default-dark fixed-layout">
<!--------------------------------------MODAL-------------------------------------------------------------------------->
<div id="portlet-config" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-mid">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Add Grievance</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
             </div>
             <div class="modal-body" >
	                 <div class="row p-l-10 p-r-10 p-b-10">
						<div class="col-md-4">
			                <select class="form-control select2 row" name="grivence" id="grivence" onchange="catagory(this.value)">
								<option value="">Select Grievance</option>
								<option style="color:red" value="1">General</option>
								<option style="color:green" value="2">Confidential</option>
						    </select>
				        </div> 
					        
				        <div class="col-md-4">
			                <select class="form-control select2 row" name="category" id="category">
								<option value="">Select Category</option>
								<option value="1">Behaviour</option>
								<option value="2">Salary</option>
								<option value="3">Other Department</option>
								<option value="4">Organization Policy</option>
								<option value="5">Others</option>
						    </select>
				        </div>
				        
				        <div class="col-md-4">
							<input class="form-control" type="file" name="documents" id="documents"/>
						</div>
						
					  </div>
					 <div class="row p-l-10 p-r-10 p-t-10">
					  	<div class="col-md-12">
			        		<label for=""></label>
			                <textarea class="form-control" rows="1" name="remark" id="remark" placeholder=" add remark"></textarea>
						</div>
					  </div>
					 <hr>
					 <div class="form-actions pull-right">
					     <button type="submit" class="btn btn-info" onclick="savegrieve()">Save</button>
					     <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					  </div>
             </div>
         </div>
	</div>
</div>
<!--------------------------------------------MAIN CONTENT--------------------------------------------------->
	
<div id="main-wrapper">
    <div class="page-wrapper">
        <div class="container-fluid">
<div class="row">
    <div class="col-md-12">
        <div class="card space">
            <div class="row  p-r-25 p-l-5">
                <div class="col-md-11">
                    <h3 class="new_title">Grievance</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ">
	<div class="col-md-12 ">
		<div class="card p-l-5 p-r-5">
			<div class="card-body ">
				<div class"p-b-15">
					<div class="row d-flex justify-content-start p-l-20 ">
						<div class="col-md-3">
			                <select class="form-control select2 row" name="srchgrivence" id="srchgrivence" onchange="srchcatagory(this.value)">
								<option value="" disabled selected>Select Grievance</option>
								<option value="1">General</option>
								<option value="2">Confidential</option>
						    </select>
				        </div> 
				        
				        <div class="col-md-3 row justify-content-start p-l-20 ">
			                <select class="form-control select2" name="category2" id="category2">
			                	<option value="" disabled selected>Select Catagory</option>
			                	<option value=(this.value)></option>
						    </select>
				        </div>
				        
				        <div class="col-md-3 row justify-content-start p-l-30 ">
				        	<div class="p-l-20 ">
		                		<button class="btn btn-info" onclick="searchgrieve()">Search</button>
		                	</div>
		                	<div class="p-l-10 p-r-30">
			                	<a href="#portlet-config" data-toggle="modal">
									<button type="submit" onclick="" class="btn btn-success"> + ADD </button>
								</a>
							</div>
		                </div>
				    </div>
				</div>
				
				
				<div class="general-container p-l-5 p-r-5 p-b-10 P-t-15">
					<div class="table-container" style="max-height:450px">
						<table class="p-l-10">
							<thead >
								<tr>
									<th>S No.</th>
									<th>Name</th>
									<th>Grievance type</th>
									<th>Catagory</th>
									<th>Document</th>
									<th>Remark</th>
									<th>HR Remark</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody id="grievedata"> 
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>


		</div>
	</div>
</div>
</body>

<script>
function catagory(id){
	$.ajax({
		type:"post",
		url:"<?php echo base_url('Web0001/catagory') ?>",
		data:{id:id},
		success: function(msg){
			$('#category').html(msg)
		}
	})
}

function srchcatagory(id){
	$.ajax({
		type:"post",
		url:"<?php echo base_url('Web0001/catagory2') ?>",
		data:{id:id},
		success: function(msg){
			$('#category2').html(msg)
		}
	})
}

function savegrieve(){
	let grivence = $('#grivence').val();
	let category = $('#category').val();
	let remark = $('#remark').val();
	let documents = $('#documents').val();
	// alert(grivence);
	// return;
	$.ajax({
		type: "post",
		url: "<?php echo base_url("Web0001/savegrieve") ?>",
		data: {
				grivence: grivence,
				category: category,
				remark: remark,
				documents: documents,
			},
		success: function(msg){
			alert(msg);
			location.reload();
		}
	})
}

searchgrieve();
function searchgrieve(){
	let srchgrivence = $('#srchgrivence').val();
	let category2 = $('#category2').val();
	$.ajax({
		type: "post",
		url: "<?php echo base_url("Web0001/searchgrieve") ?>",
		data: {
				srchgrivence: srchgrivence,
				category2: category2,
			},
		success: function(msg){
			// alert(msg)
			$('#grievedata').html(msg);
		}
	})
}
		
</script>


</html>
