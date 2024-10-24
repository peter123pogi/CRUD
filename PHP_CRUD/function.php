<?php
include 'db.php';
function createUser(array $arr) {
    global $con;
    $col = '';
    $field = '';

    //----Dynamically concatenates columns and fields based on the keys and values given in the associative array--------------
    foreach($arr as $key => $val) {
        if($key != 'id') {
            $isKeyNull = ($val != NULL) ? "$key," : '';
            $isValNull = ($val != NULL) ? "'$val'," : '';
            
            $col.= $isKeyNull;
            $field.= $isValNull;
        }
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
function updateUser(array $arr) {
    global $con;
    $set = '';

    //----Dynamically concatenates columns and fields based on the keys and values given in the associative array--------------
    foreach($arr as $key => $val) {
        if($key != 'id') {
            $isValNull = "'$val',";
            $isKeyNull = ($val != NULL) ? "$key = $isValNull" : "$key = 'No Info',";
        
            $set.= "$isKeyNull";
        }
    }
    //------------------------------------------------------------------------------------------------------------------------------

    //------Cut the comma of the last character in the concatenated string after the loop-------------------------------------------
    $set = rtrim($set, ',');

    mysqli_query($con, "UPDATE users SET $set WHERE id = {$arr['id']};");

    header("Location: {$_SERVER['REQUEST_URI']}");
    exit;
}
function deleteUser(int $id) {
    global $con;

    mysqli_query($con, "DELETE FROM users WHERE id = $id;");

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $url = "$protocol://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $urlParts = parse_url($url);

    $clearParam = "{$urlParts['scheme']}://{$urlParts['host']}{$urlParts['path']}";//making sure the url parameters are cleared to avoid unecessary display of url parameters
    header("Location: $clearParam");
    exit;
}
function displayUsers() {
    global $con;
    $res = mysqli_query($con, "SELECT * FROM users;");
    if(mysqli_num_rows($res) > 0) {
        $c = 1;
        while($row = $res -> fetch_assoc()) {
            $r = json_encode($row);
            $sex = ($row['sex'] != 'Male') ? "venus" : "mars";
            echo "
                <tr>
                    <td><div>$c.</div></td>
                    <td><div>{$row['name']}</div></td>
                    <td><div>{$row['age']}</div></td>
                    <td><div><i class='fa-solid fa-$sex'></i></div></td>
                    <td><div>{$row['email']}</div></td>
                    <td><div>{$row['contact_number']}</div></td>
                    <td><div>{$row['created_at']}</div></td>
                    <td>
                        <div class='flex gp-1'>
                            <button title='Update' onclick='showUpdate(true, $r, \"{$row['id']}\")' style='cursor: pointer; height: 1.6rem; width: 1.6rem; background: green; color: white; border-radius: 100%;'><i class='fa-solid fa-pen'></i></button>
                            <a title='Delete' onclick='submitChanges(event,\"{$row['name']}\", \"delete\")' href='{$_SERVER['REQUEST_URI']}?id={$row['id']}&delete=true' class='flex justify-center align-center' style='cursor: pointer; height: 1.6rem; width: 1.6rem; background: red; color: white; border-radius: 100%;'><i class='fa-solid fa-trash'></i></a>
                        </div>
                    </td>
                </tr>
            ";
            $c++;
        }
    }else {
        echo "
            <tr>
                <td colspan='8' style='text-align: center;'>No Users Yet</td>
            </tr>   
        ";
    }
}
