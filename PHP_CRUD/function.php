<?php
include 'db.php';
function createUser(array $arr) {
    global $con;
    $col = '';
    $field = '';

    //----Dynamically concatenates columns and fields based on the keys and values given in the associative array--------------
    foreach($arr as $key => $val) {
        $isKeyNull = ($val != NULL) ? "$key," : '';
        $isValNull = ($val != NULL) ? "'$val'," : '';
        
        $col.= $isKeyNull;
        $field.= $isValNull;
    }
    //------------------------------------------------------------------------------------------------------------------------------

    //------Cut the comma of the last character in the concatenated string after the loop-------------------------------------------
    $col = rtrim($col, ',');
    $field = rtrim($field, ',');
    //------------------------------------------------------------------------------------------------------------------------------ 
    
    mysqli_query($con, "INSERT INTO users ($col) VALUES ($field);");
    
    header("Location: {$_SERVER['REQUEST_URI']}");//Ensuring that all data in the post request are cleared to avoid uneccessary data insertion when clicking the reload button
    exit;
}
function displayUsers() {
    global $con;
    $res = mysqli_query($con, "SELECT * FROM users;");
    if(mysqli_num_rows($res) > 0) {
        $c = 1;
        while($row = $res -> fetch_assoc()) {
            echo "
                <tr>
                    <td><div>$c.</div></td>
                    <td><div>{$row['name']}</div></td>
                    <td><div>{$row['age']}</div></td>
                    <td><div>{$row['sex']}</div></td>
                    <td><div>{$row['email']}</div></td>
                    <td><div>{$row['contact_number']}</div></td>
                    <td><div>{$row['created_at']}</div></td>
                </tr>
            ";
            $c++;
        }
    }else {
        echo "
            <tr>
                <td colspan='7' style='text-align: center;'>No Users Yet</td>
            </tr>   
        ";
    }
}