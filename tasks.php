<?php
class Tasks
{
    //Db declarations
    public $connect;
    private $dbhost = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "task_management";
    
    //Function to create db connection
    function __construct()
    {
        $this->db_connect();
    }
    
    //Db connection function
    
    public function db_connect()
    {
        $this->connect = mysqli_connect($this->dbhost, $this->username,$this->password,$this->db);
    }
    
    //Function to execute every query request
    public function execute_query($qry)
    {
        return mysqli_query($this->connect, $qry);
    }
    
    //Fetch data into the table
    
    public function fetch_data_into_table($qry)
    {
        $output = '';
        $result = $this->execute_query($qry);
        $output .='
            <table class="table table-bordered table-striped" id="task_table">
                <tr>
                    <th>Sl.No</th>
                    <th>Task Id </th>
                    <th>Name </th>
                    <th>Description </th>
                    <th>Created Date </th>
                    <th>Updated Date </th>
                    <th>Action</th>
                </tr>';
        $i = 1;
        while($row=mysqli_fetch_object($result))
        {
            $cdate = date('d-M-Y H:i:s', strtotime($row->created_at));
            $udate = date('d-M-Y H:i:s', strtotime($row->updated_at));
            $output .='
            <tr>
                <td>'.$i.'</td>
                <td>'.$row->id.'</td>
                <td>'.$row->name.'</td>
                <td>'.$row->description.'</td>
                <td>'.$cdate.'</td>
                <td>'.$udate.'</td>
                <td><a href="index.php?tid='.$row->id.'"><button class="btn btn-primary btn-edit" id="'.$row->id.'" title="Edit Task">Edit</button></a>  &emsp; <button class="btn btn-danger btn-delete" id="'.$row->id.'" title="Delete Task">Delete</button></td>
            </tr>';
            $i++;
        }
        
        $output .= '</table>';
        return $output;
    }
        
        
}
    
?>