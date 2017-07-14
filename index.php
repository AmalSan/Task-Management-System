<?php
include('tasks.php');
error_reporting(0);
$task = new Tasks();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Task Management System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <style>
            #task_table .edit_input
            {
                border-color: transparent;
                background-color: transparent;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h3 class="text-center">Task Management System</h3>
            <br>
            <br>
            
            <?php if(isset($_GET['tid']))
            {
                $tid = $_GET['tid'];
                $query = "SELECT * FROM tasks WHERE id='$tid'";
                $result = $task->execute_query($query);
                $row = mysqli_fetch_object($result);
            ?>
                <h4>Edit Task</h4>
                <br>
                <br>
                <form method="post" id="edit_task_form">
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="<?php echo $row->name;?>">
                    </div>
                    <div class="form-group">
                      <label for="description">Description:</label>
                      <textarea name="description" rows="4" cols="10" id="description" class="form-control" placeholder="Enter description"><?php echo $row->description;?></textarea>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Update Task" name="create_task" id="update_task" class="btn btn-primary"/>
                </form>
            
            <?php }
            else
            {?>
                <h4>Add New Task</h4>
                <br>
                <br>
                <form method="post" id="task_form">
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
                    </div>
                    <div class="form-group">
                      <label for="description">Description:</label>
                      <textarea name="description" rows="4" cols="10" id="description" class="form-control" placeholder="Enter description"></textarea>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Create Task" name="create_task" id="create_task" class="btn btn-primary"/>
                </form>
                
        <?php    }
            ?>
            <br>
            <br>
            
            <div id="task_list_table" class="table-responsive">
            </div>
        </div>
    </body>
</html>
<script>

$(document).ready(function(){
   

/* Ajax functions to list all tasks */    
    
    view_tasks();
    function view_tasks()
    {
        var response = "viewTask";
        var url = "actions.php";
        $.ajax({
            url : url,
            method : "POST",
            data: {response:response},
            success:function(result)
            {
                $('#task_list_table').html(result);
            }
            
        });
    }
        
/* End of task lists*/        
    
/* Ajax functions to create task */    
    $('#task_form').on('submit', function(event){
       
        event.preventDefault();
        var response = "addTask";
        var name = $('#name').val().trim();
        if(name=='')
        {
            $('#name').css("border-color", "red").focus();
            setTimeout(function(){
                $('#name').css("border-color", "#ccc").focus();    
            }, 2000);
            
            return false;
        }
        var desc = $('#description').val().trim();
        if(desc=='')
        {
            $('#description').css("border-color", "red").focus();    
            setTimeout(function(){
                $('#description').css("border-color", "#ccc").focus();    
            }, 2000);
            
            return false;
        }
        if(name !='' && desc !='')
        {
            var url = "actions.php";
            $.ajax({
               
                url: url,
                method: "POST",
                data: {name: name, description: desc, response:response},
                success:function(result)
                {
                    alert(result);        
                    $('#task_form')[0].reset();
                    view_tasks();
                }
                
            });
        }
        else
        {
            alert('Please enter all the fields');
        }
            
    });
/* End of create task */    
    
    
    /* Ajax functions to edit task */    
    $('#edit_task_form').on('submit', function(event){
        var tid = "<?php echo $_GET['tid'];?>";
        event.preventDefault();
        var response = "editTask";
        var name = $('#name').val().trim();
        if(name=='')
        {
            $('#name').css("border-color", "red").focus();
            setTimeout(function(){
                $('#name').css("border-color", "#ccc").focus();    
            }, 2000);
            
            return false;
        }
        var desc = $('#description').val().trim();
        if(desc=='')
        {
            $('#description').css("border-color", "red").focus();    
            setTimeout(function(){
                $('#description').css("border-color", "#ccc").focus();    
            }, 2000);
            
            return false;
        }
        if(name !='' && desc !='')
        {
            var url = "actions.php";
            $.ajax({
               
                url: url,
                method: "POST",
                data: {name: name, description: desc, response:response, tid:tid},
                success:function(result)
                {
                    alert(result);        
                    $('#edit_task_form')[0].reset();
                    view_tasks();
                    window.location.href='index.php';
                }
                
            });
        }
        else
        {
            alert('Please enter all the fields');
        }
            
    });
/* End of edit task */    

    /*Ajax Delete task*/
    
    $('body').on('click', '.btn-delete', function(){
        if(confirm("Are you sure to delete this task?"))
        {
            var tid = $(this).attr("id");
            if(tid !='')
            {
                var url = "actions.php";
                var response ="deleteTask";
                $.ajax({

                    url: url,
                    method: "POST",
                    data:{tid:tid, response: response},
                    success:function(result)
                    {
                        alert(result);
                        view_tasks();
                    }

                });
            }
            else
            {
                alert("Can't delete. Try again");
            }
                
        }
            
    });
    
});
</script>