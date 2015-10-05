<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

/**
 * Created by PhpStorm.
 * User: idhamhafidz
 * Date: 10/4/15
 * Time: 12:09 PM
 * Property Of JOMos
 *
 * @description This script is to help generate mysql query
 */

class mysqlQueryGenerator{

    public $servername     = "localhost";
    public $username       = "root";
    public $password       = "idham11880";
    public $database       = "mii_ilms";
    public $conn;

    public function __construct(){
        // Create connection to ilms db
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
    }

    /**
     * @description This will show all the table inside the database first
     */
    public function index()
    {
        $result = $this->conn->query("SHOW TABLES");
        /*echo '<pre>';
        print_r($result);
        echo '</pre>'*/;
        echo '<h1>Welcome to Idham Hafidz MYSQL Query Generator</h1>';
        echo '<h3>There are '.$result->num_rows.' number of tables</h3>';
        echo '<table>';
        echo '<tr>';
            echo '<th>Table Name</th>';
            echo '<th></th>';
        echo '</tr>';

        while($row = $result->fetch_assoc()) {
        echo '<tr>';
            echo '<td>'.$row['Tables_in_'.$this->database].'</td>';
            echo '<td><a href="show_fields.php?table_name='.$row['Tables_in_'.$this->database].'">Show Fields</td>';
        echo '</tr>';
        }

        echo '</table>';

    }

    /**
     * @description This will show the fields of the selected table
     * @param $tableName string the table name derive from $_GET
     * @param $selected array From $_POST['selected']
     */
    public function showFields($tableName, $selected=array() )
    {
        $result = $this->conn->query("DESC $tableName ");
        $i = 1;
        echo '<h1>Field Name For Table <font color="red">'. $tableName.'</font></h1>';
        echo '<h3><u>Select Field You Want To Use In Your Query Statement, and click the button to generate</u></h3>';
        echo '<h3><b>Use IGNORE_ME whenever you want the field to be ignored</b></h3>';
        echo '<a href="index.php">Back To Table List</a>';
        echo '<table>';
        echo '<tr>';
            echo '<th></th>';
            echo '<th><input type="checkbox" name="select_all" value="1" /></th>';
            echo '<th>Field Name</th>';
            echo '<th>Type</th>';
            echo '<th>Null</th>';
            echo '<th>Key</th>';
            echo '<th>Default</th>';
            echo '<th>Extra</th>';
            echo '<th>Insert/Update Value <br /> Use IGNORE_ME</th>';
            echo '<th>Update/Delete WHERE Value</th>';
        echo '</tr>';

        echo '<form method="POST" action="">';

        $c = 0;

        while ($row = $result->fetch_assoc())
        {
            /*echo '<pre>';
            print_r($row);
            echo '</pre>';*/
            $stripe = ($c++%2==1) ? 'odd' : 'even';
            echo '<tr class="'.$stripe.'">';
                echo '<td>'.$i.'</td>';
                if (in_array($row['Field'], $selected)) {
                    echo '<td><input type="checkbox" name="selected[]" value="'.$row['Field'].'" checked /></td>';
                } else {
                    echo '<td><input type="checkbox" name="selected[]" value="'.$row['Field'].'" /></td>';
                }
                echo '<td>'.$row['Field'].'</td>';
                echo '<td>'.$row['Type'].'</td>';
                echo '<td>'.$row['Null'].'</td>';
                echo '<td>'.$row['Key'].'</td>';
                echo '<td>'.$row['Default'].'</td>';
                echo '<td>'.$row['Extra'].'</td>';
                if(isset($_POST['insert_update_value_'.$row['Field'].'']))
                {
                    $value_insert_update = $_POST['insert_update_value_'.$row['Field'].''];
                } else {
                    $value_insert_update = '';
                }
                if (in_array($row['Field'], $selected)) {
                    echo '<td><input type="text" name="insert_update_value_'.$row['Field'].'" value="'.$value_insert_update.'" /></td>';
                } else {
                    echo '<td><input type="text" name="insert_update_value_'.$row['Field'].'"  /></td>';
                }
                if(isset($_POST['update_delete_value_'.$row['Field'].'']))
                {
                    $value_update_delete = $_POST['update_delete_value_'.$row['Field'].''];
                } else {
                    $value_update_delete = '';
                }
                if (in_array($row['Field'], $selected))
                {
                    echo '<td><input type="text" name="update_delete_value_'.$row['Field'].'" value="'.$value_update_delete.'" /></td>';
                } else {
                    echo '<td><input type="text" name="update_delete_value_'.$row['Field'].'"  /></td>';
                }
            echo '</tr>';
            $i++;
        }

        echo '<tr>';
        echo '<td colspan="5"><br /><br />';
        echo '<input type="submit" name="generateInsertQuery" value="Generate Insert Query" />';
        echo '<input type="submit" name="generateUpdateQuery" value="Generate Update Query" />';
        echo '<input type="submit" name="generateDeleteQuery" value="Generate Delete Query" />';
        echo '</td>';
        echo '</tr>';
        echo '</form>';
        echo '</table>';
    }

    /**
     * @description This will generate update query base on the selected field
     */
    public function generateUpdateQuery()
    {

    }
}



?>