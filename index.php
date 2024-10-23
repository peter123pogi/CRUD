<?php
include 'function.php';
if(isset($_POST['submit'])) {
    global $isPopup;
    $user = [
        'name' => $_POST['name'], 
        'age' => $_POST['age'], 
        'sex' => $_POST['sex'], 
        'email' => (array_key_exists('email', $_POST) ? $_POST['email'] : NULL), 
        'contact_number' => (array_key_exists('contact-num', $_POST) ? $_POST['contact-num'] : NULL)
    ];//create an associative array and set its keys for the column and values for the field for the data insertion
    createUser($user);   //call the create user function to insert the data and pass the $user variable to the function's parameter
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Operation</title>
    <link rel="stylesheet" href="style.css">
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
                            <label for="">Name</label>
                        </div>
                        <div class="input-border">
                            <input type="number" name="age" value="" id="" required placeholder="">
                            <label for="">Age</label>
                        </div>
                        <div class="fll-w radio">
                            <label for="">Sex</label>
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
                            <button type="submit" name="submit" class="submit fll-w">Submit</button>
                            <p title="See Users" onclick="showList(true)" class="btn">See All Your Users Here</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="user-list" class="fll-w fll-h abs" style="z-index: 1;">
            <div class="popup flex flex-col gp-1">
                <h1 style="font-size: 1.5em;">My List of Users</h1>
                <div class="fll-w table-container overflow">
                    <table class="fll-w text-left">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Added Since</th>
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
        </div>
    </main>
</body>
<script>
    document.getElementById('user-list').style.display = 'none'

    function showList(s) {
        document.getElementById('user-list').style.display = (s != true) ? 'none' : 'block'
    }
</script>
</html>
