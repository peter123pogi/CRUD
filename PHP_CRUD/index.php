<?php
include 'function.php';

$user = [
    'name' => (array_key_exists('name', $_POST) ? ucwords($_POST['name']) : NULL), 
    'age' => (array_key_exists('age', $_POST) ? $_POST['age'] : NULL), 
    'sex' => (array_key_exists('sex', $_POST) ? $_POST['sex'] : NULL), 
    'email' => (array_key_exists('email', $_POST) ? strtolower($_POST['email']) : NULL), 
    'contact_number' => (array_key_exists('contact-num', $_POST) ? $_POST['contact-num'] : NULL)
];  //create an associative array and set its keys for the column and values for the field to set the data manipulation

if(isset($_POST['create'])) {
    global $user;
    createUser($user); //call the createUser function to insert the data and pass the $user variable to the function's parameter
}
if(isset($_POST['update'])) {
    global $user;
    $user['id'] = $_POST['update'];
    updateUser($user); //call the updateUser function to update the data and pass the $user variable to the function's parameter
}
if(isset($_GET['delete'])) {
    deleteUser($_GET['id']);//call the deleteUser function to delete the data and pass the $_GET['id'] super global to the function's parameter
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Operation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <main>
        <div class="fll-w abs flex justify-center" style="z-index: -1;">
            <form action="" method="post">
                <div class="main-form flex flex-col gp-3">
                    <h1 style="font-size: 25px; text-align: center;">My Users' Information</h1>
                    <div class="flex flex-col gp-3">
                        <div class="input-border">
                            <input type="text" name="name" value="" id="" required placeholder="">
                            <label for="">Name*</label>
                        </div>
                        <div class="input-border">
                            <input type="number" name="age" value="" id="" required placeholder="">
                            <label for="">Age*</label>
                        </div>
                        <div class="fll-w radio">
                            <label for="">Sex*</label>
                            <div class="flex item-center gp-1">
                                <input type="radio" name="sex" id="male" value="Male" required>
                                <label for="male">Male</label>
                            </div>
                            <div class="flex item-center gp-1">
                                <input type="radio" name="sex" id="female" value="Female" required>
                                <label for="female">Female</label>
                            </div>
                        </div>
                        <div class="input-border">
                            <input type="email" name="email" value="" id="" placeholder="">
                            <label for="">Email</label>
                        </div>
                        <div class="input-border">
                            <input type="text" name="contact-num" value="" id="" maxlength="11" placeholder="">
                            <label for="">Contact #</label>
                        </div>
                        <div>
                            <button type="submit" name="create" class="submit fll-w">Create</button>
                            <p title="See Users" onclick="showList(true)" class="btn">See All Your Users Here</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="user-list" class="fll-w fll-h abs none" style="z-index: 1;">
            <div class="popup flex flex-col gp-1">
                <div class="fll-w none" id="list">
                    <h1 style="font-size: 1.5em;">My List of Users</h1>
                    <div class="fll-w table-container overflow">
                        <table class="fll-w text-left">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Email</th>
                                <th>Contact No.</th>
                                <th>Added Since</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php displayUsers(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="fll-w flex justify-end">
                        <button type="button" class="cancel" onclick="showList(false)">Cancel</button>
                    </div>
                </div>
                <div class="fll-w" id="update-user">
                    <form action="" method="post" id="update-form" class="flex flex-col gp-3">
                        <h1 style="font-size: 1.5em;">Update <span id="name"></span></h1>
                        <div class="flex gp-1">
                            <div class="input-border">
                                <input type="text" name="name" value="" id="" required placeholder="">
                                <label for="">Name*</label>
                            </div>
                            <div class="input-border">
                                <input type="number" name="age" value="" id="" required placeholder="">
                                <label for="">Age*</label>
                            </div>
                        </div>
                        <div class="fll-w radio">
                            <label for="">Sex*</label>
                            <div class="flex item-center gp-1">
                                <input type="radio" name="sex" id="male2" value="Male" required>
                                <label for="male2">Male</label>
                            </div>
                            <div class="flex item-center gp-1">
                                <input type="radio" name="sex" id="female2" value="Female" required>
                                <label for="female2">Female</label>
                            </div>
                        </div>
                        <div class="flex gp-1">
                            <div class="input-border">
                                <input type="email" name="email" value="" id="" placeholder="">
                                <label for="">Email</label>
                            </div>
                            <div class="input-border">
                                <input type="text" name="contact-num" value="" id="" maxlength="11" placeholder="">
                                <label for="">Contact #</label>
                            </div>
                        </div>
                        <div class="fll-w flex justify-end gp-1">
                            <button type="button" class="cancel" onclick="showUpdate(false)">Cancel</button>
                            <button type="update" class="cancel" name="update" onclick="submitChanges(event, n, 'update')">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script>
    document.getElementById('user-list').style.display = 'none'
    let n =document.querySelector("#update-user input[name='name']").value

    function showList(s) {
        document.getElementById('user-list').style.display = (s != true) ? 'none' : 'block'
        document.getElementById('list').style.display = (s != true) ? 'none' : 'block'
        document.getElementById('update-user').style.display = (s != true) ? 'block' : 'none'
    }
    function showUpdate(s, user) {
        document.getElementById('update-user').style.display = (s != true) ? 'none' : 'block'
        document.getElementById('list').style.display = (s != true) ? 'block' : 'none'

        if(s) {
            const sx = (user.sex != 'Male') ? 'female' : 'male'
            
            document.querySelector('#update-user h1 span').innerText = user.name

            document.querySelector("#update-user button[name='update']").value = user.id
            n = user.name
            document.querySelector("#update-user input[name='name']").value = user.name
            document.querySelector("#update-user input[name='age']").value = user.age
            document.querySelector(`#update-user #${sx}2`).checked = true
            document.querySelector("#update-user input[name='email']").value = (user.email != 'No Info') ? user.email : ''
            document.querySelector("#update-user input[name='contact-num']").value = (user.contact_number != 'No Info') ? user.contact_number : ''
        } 
    }
    function submitChanges(e, name, c) {
        c = (c != 'delete') ? 'Update' : 'Delete'
        if (!confirm(`Are you Sure you Want to ${c} ${name}?`)) {
            e.preventDefault()
        }
    }
</script>
</html>
