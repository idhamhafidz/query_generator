<?php
/**
 * Created by PhpStorm.
 * User: idhamhafidz
 * Date: 10/5/15
 * Time: 1:14 AM
 * Property Of JOMos
 */


include("class.php");
?>
<html>
<head>
<style>
    .even { background-color:#FFF; }
    .odd { background-color: #87cefa; }
    textarea {background-color: lightcyan;}
</style>
</head>
<body>
<?php
$table_name = $_GET['table_name'];

$generator = new mysqlQueryGenerator();

if(isset($_POST['generateUpdateQuery']))
{
    /*echo '<pre>';
    print_r($_POST['selected']);
    echo '</pre>';*/

    //validate first. One field from value_update_delete must be use as reference for WHERE
    $WHERE_exist = 0;
    foreach($_POST['selected'] as $fieldName)
    {
        if($_POST['update_delete_value_'.$fieldName] != '')
        {
            $WHERE_exist = 1;
        }
    }

    if($WHERE_exist != 1)
    {
        echo '<script type="text/javascript">alert("NEED WHERE VALUE!");</script>';
        echo '<h3><font color="red">Query Not Generated. Need WHERE Value fill in at least once!</font></h3>';
    } else {
        echo '<h3>Query Result</h3>';
        echo '<textarea cols="100" rows="5">';
        $array_size = sizeof($_POST['selected']);
        $i = 1;

        echo "UPDATE ".$table_name;
        echo " SET ";

        foreach($_POST['selected'] as $fieldName)
        {

            if($_POST['insert_update_value_'.$fieldName] != 'IGNORE_ME')
            {
                echo $fieldName." =  '".$_POST['insert_update_value_'.$fieldName]."' ";
                if($i != $array_size)
                {
                    echo ", ";
                }
            }

            $i++;
        }

        echo " WHERE ";
        foreach($_POST['selected'] as $fieldName)
        {
            if($_POST['update_delete_value_'.$fieldName] != '')
            {
                echo $fieldName." =  '".$_POST['update_delete_value_'.$fieldName]."' ";
            }
        }

        echo '</textarea>';
    }

    //echo '<script type="text/javascript">alert("testing okay");</script>';

    $generator->showFields($table_name, $_POST['selected']);

} else {
    $generator->showFields($table_name);

}



?>
</body>
</html>