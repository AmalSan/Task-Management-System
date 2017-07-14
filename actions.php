 <?php    
 include ('tasks.php');  
 $task = new Tasks();  
 if(isset($_POST["response"]))  
 {      
    //View all tasks   
      if($_POST["response"] == "viewTask")  
      {  
           echo $task->fetch_data_into_table("SELECT * FROM tasks ORDER BY id DESC");  
      }  
     //Add new task
      if($_POST["response"] == "addTask")  
      {  
           $name = mysqli_real_escape_string($task->connect, $_POST["name"]);  
           $desc = mysqli_real_escape_string($task->connect, $_POST["description"]);  
           
           $query = "  
           INSERT INTO tasks  
           (name, description, created_at)   
           VALUES ('".$name."', '".$desc."', NOW())  
           ";  
           $task->execute_query($query);  
           echo 'New task inserted';  
      }  
     //Edit the task
     if($_POST["response"] == "editTask")  
      {  
           $tid = mysqli_real_escape_string($task->connect, $_POST["tid"]);  
           $name = mysqli_real_escape_string($task->connect, $_POST["name"]);  
           $desc = mysqli_real_escape_string($task->connect, $_POST["description"]);  
           
           $query = "  
           UPDATE tasks  
           SET name='".$name."', description='".$desc."' WHERE id='".$tid."'";  
           $task->execute_query($query);  
           echo 'Task details updated successfully.';  
      }
     
     //Delete the task
     if($_POST['response'] == "deleteTask")
     {
         $tid = mysqli_real_escape_string($task->connect, $_POST['tid']);
         
         $query = "DELETE FROM tasks WHERE id='$tid'";
         $task->execute_query($query);
         echo 'Task deleted successfully.';
     }
 }  
 ?>  