<!doctype html>
<head>
    
    <title>Table Crud</title>

    <link rel="stylesheet" type="text/css" href="styles.css">
    
	<!-- bootstrap Lib -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- datatable lib -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
   
</head>

                    <br><br>
                   

<body>


   <div class="content"> 
    <h1>Solution of the Problem!</h1>   
                    
                    <div align="right">
                        <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success btn-lg"> <i class="fa fa-bars">&nbsp;</i>  Add Solution</button>                       
                    </div> <br> <br>
                 
                <table id="course_table" class="table table-striped">  
                    <thead bgcolor="#6cd8dc">
                        <tr class="table-primary">
                           <th width="10%">ID</th>
                           <th width="50%">Descrição</th>  
                           <th width="50%">Solução</th>
                           <th width="50%">Data Lançamento</th>
                           <th width="10%">Arquivo</th>
                           <th scope="col" width="5%">Edit</th>
                           <th scope="col" width="5%">Delete</th>
                        </tr>
                    </thead>
                </table>
            </br>
                
   </div>               
 </body>
 </html>


<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="course_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Solution</h4>
                </div>
                <div class="modal-body">
                    <label>Descrição</label>
                    <input type="text" name="course" id="course" class="form-control" />
                    <br />
                    <label>Solução</label>
                    <input type="text" name="students" id="students" class="form-control" />
                    <br /> 
                </div>
                <div class="modal-body">
                <label>Arquivo</label>
                     <br />
                     <form method="POST" action="upload.php" enctype="multipart/form-data">
                    <input name="arquivo" type="file"><br><br>   
                    </form>
                    <br /> 
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="course_id" id="course_id" />
                    <input type="hidden" name="operation" id="operation" />
                    <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    $('#add_button').click(function(){
        $('#course_form')[0].reset();
        $('.modal-title').text("Add Solution!");
        $('#action').val("Add");
        $('#operation').val("Add");
    });
    
    var dataTable = $('#course_table').DataTable({
        "paging":true,
        "processing":true,
        "serverSide":true,
        "order": [],
        "info":true,
        "ajax":{
            url:"fetch.php",
            type:"POST"
               },
        "columnDefs":[
            {
                "targets":[0,3,4],
                "orderable":false,
            },
        ],    
    });

    $(document).on('submit', '#course_form', function(event){
        event.preventDefault();
        var id = $('#id').val();
        var course = $('#course').val();
        var students = $('#students').val();
        
        if(course != '' && students != '')
        {
            $.ajax({
                url:"insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                    $('#course_form')[0].reset();
                    $('#userModal').modal('hide');
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            alert("Preencha todos os campos!");
        }
    });
    
    $(document).on('click', '.update', function(){
        var course_id = $(this).attr("id");
        $.ajax({
            url:"fetch_single.php",
            method:"POST",
            data:{course_id:course_id},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#id').val(data.id);
                $('#course').val(data.course);
                $('#students').val(data.students);
                $('.modal-title').text("Edit Course Details");
                $('#course_id').val(course_id);
                $('#action').val("Save");
                $('#operation').val("Edit");
            }
        })
    });
    
    $(document).on('click', '.delete', function(){
        var course_id = $(this).attr("id");
        if(confirm("Are you sure you want to delete this user?"))
        {
            $.ajax({
                url:"delete.php",
                method:"POST",
                data:{course_id:course_id},
                success:function(data)
                {
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;   
        }
    });
    
    
});
</script>