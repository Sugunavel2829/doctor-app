<?php 
include_once './assets/config/config.php';
?>
<title> Doctor Schedule</title>
<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
<script src="./assets/js/jquery.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./assets/js/all.js" data-auto-replace-svg="nest"></script>

<script src="./assets/js/main.js"></script>

<script src="./assets/js/jquery.dataTables.min.js"></script>
<script src="./assets/js/dataTables.bootstrap.min.js"></script>        
 <script src="./assets/js/bootstrap-datepicker.js"></script>


<link rel="stylesheet" href="./assets/css/dataTables.bootstrap.min.css" />
<link href="./assets/css/bootstrap-datepicker.css" rel="stylesheet">
        <link href="./assets/css/bootstrap-datepicker3.css" rel="stylesheet">

<div class="container contact"> 
    <h2>Appointment Details </h2>    
    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">        
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="panel-title"></h3>
                </div>
               
                <div class="col-md-2" align="right">
                    <a href="doctor.php">
                    <button type="button" class="btn btn-success">Back To Home</button>
                </a>
                </div>
            </div>
        </div>
     <table id="recordListing" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>                   
                    <th>Patient Email</th>                    
                    <th>Patient Mobile</th>
                    <th>Doctor Name</th>
                    <th>Date</th>
                    <th>From Time</th>
                    <th>To Time</th>
                   <th>Symptom</th> 
                    <th>Comments</th>                                     
                                    
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM appointment ORDER BY id DESC";
                $result=mysqli_query($conn,$sql);
                $numrows = mysqli_num_rows($result);
                $sno=1;
                if($numrows){
                    $curdatetime=date('Y-m-d H:i:s');
                    foreach ($result as $key => $value) {
                        $start_time=date("h:i A", strtotime($value['from_time']));
                        $end_time=date("h:i A", strtotime($value['to_time']));
                ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo $value['pat_name']; ?></td>
                        <td><?php echo $value['pat_email']; ?></td>
                        <td><?php echo $value['pat_mobile']; ?></td>
                        <td><?php echo $value['doc_name']; ?></td>
                        <td><?php echo $value['appdate']; ?></td>
                        <td><?php echo $start_time; ?></td>
                        <td><?php echo $end_time; ?></td>
                        <td><?php echo $value['symptom'];?></td>
                        <td><?php echo $value['comment'];?></td>
                    </td>
                        
                    </tr>
                    <?php
                    $sno++;
                    } 
                }else{
                ?>
                <tr>
                    <td colspan="5">No Records Found</td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table> 
    </div>
    <div id="recordModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="recordForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Doctor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>          
                        </div>
                        <div class="form-group">
                            <label class="control-label">Qualification</label>                          
                            <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Qualification">                            
                        </div>      
                        <div class="form-group">
                            <label class="control-label">Doctor Image</label>                          
                            <input type="file" class="form-control"  id="image" name="image" required>                           
                        </div>   
                        
                        <div class="form-group">
                            <label class="control-label">Location</label>                         
                            <input type="text" class="form-control" id="location" name="location" placeholder="Location">          
                        </div>   
                        <div class="form-group">
                            <label class="control-label">From Date Time</label>                         
                            <input autocomplete="off" type="text" class="form-control dateTime"  name="fromTime" id="fromTime" value="<?php echo date("Y-m-d")?>">       
                        </div>   
                        <div class="form-group">
                            <label class="control-label">To Date Time</label>                         
                            <input autocomplete="off" type="text" class="form-control dateTime"  name="toTime" id="toTime" value='2021-02-17 19:06:36'>       
                        </div>                      
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id" />
                        <input type="hidden" name="action" id="action" value="" />
                        <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>  
<script type="text/javascript">
    

$(document).ready(function() {
         

  $('#recordListing').DataTable( 
      {
         dom: 'Bfrtip',
            buttons: [
                'print',
            {
                extend: 'excelHtml5',
                 title: 'Employee Report'
            },
            
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title: 'Employee Report'
            },
           
        ]

});

});
    function addDoctor(){
        $('#recordModal').modal('show');
        $('#recordForm')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i>  Add Doctor");
        $('#action').val('addRecord');
        $('#save').val('Add');
    };  

    $("#recordModal").on('submit','#recordForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled');
        var data = new FormData($('#recordForm')[0]);
            $.each($("input[type=file]"), function(i, obj) {
                var name = $(this).attr('id');
                $.each(obj.files,function(j,file){
                    data.append('files['+name+']', file);
                })
            });                 
        $.ajax({
            url:"action.php?request=DoctorInsert",
            data : data,
            type : 'post',
            cache: false,
            processData: false,
            contentType: false,
            success:function(data){ 
                if(data.trim()=='insert'){
                    alert("Doctor Added Successfully");
                    $('#recordForm')[0].reset();
                    $('#recordModal').modal('hide');                
                    $('#save').attr('disabled', false);
                    loadData('index.php');
                }else{
                    alert("Doctor Updated Successfully");
                    $('#recordForm')[0].reset();
                    $('#recordModal').modal('hide');                
                    $('#save').attr('disabled', false);
                    loadData('index.php');
                }           
            }
        })
    }); 
</script>