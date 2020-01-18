<?php
session_start();
if (isset($_GET["token"])) {
    if (isset($_SESSION["token"]) and $_SESSION["token"] == $_GET["token"]) {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Register</title>
            <style>
                body {
                    font-family: Arial, Helvetica, sans-serif;
                    background-color: black;
                }

                * {
                    box-sizing: border-box;
                }

                /* Add padding to containers */
                .container {
                    padding: 16px;
                    background-color: white;
                }

                /* Full-width input fields */
                textarea,
                input[type=text],
                input[type=password] {
                    width: 100%;
                    padding: 15px;
                    margin: 5px 0 22px 0;
                    display: inline-block;
                    border: none;
                    background: #f1f1f1;
                }

                textarea:focus,
                input[type=text]:focus,
                input[type=password]:focus {
                    background-color: #ddd;
                    outline: none;
                }

                /* Overwrite default styles of hr */
                hr {
                    border: 1px solid #f1f1f1;
                    margin-bottom: 25px;
                }

                /* Set a style for the submit button */
                .registerbtn {
                    background-color: #4CAF50;
                    color: white;
                    padding: 16px 20px;
                    margin: 8px 0;
                    border: none;
                    cursor: pointer;
                    width: 100%;
                    opacity: 0.9;
                }

                .registerbtn:hover {
                    opacity: 1;
                }

                /* Add a blue text color to links */
                a {
                    color: dodgerblue;
                }

                /* Set a grey background color and center the text of the "sign in" section */
                .signin {
                    background-color: #f1f1f1;
                    text-align: center;
                }
            </style>
        </head>

        <body>
            <?php
                    $Username = $Email = $NameTitle = $FirstName = $LastName = $PhoneNumber = $Address = "";
                    if (isset($_POST['usn'], $_POST['email'], $_POST['psw'], $_POST['psw-repeat'], $_POST['tn'], $_POST['fn'], $_POST['ln'], $_POST['pn'], $_POST['adr'])) {
                        require_once './config/dbconf.php';
                        require_once './config/variables.php';
                        $conn = newConnect();
                        $Username = $_POST['usn'];
                        $Password = $_POST['psw'];
                        $PasswordRepeat = $_POST['psw-repeat'];
                        $Email = $_POST['email'];
                        $NameTitle = $_POST['tn'];
                        $FirstName = $_POST['fn'];
                        $LastName = $_POST['ln'];
                        $PhoneNumber = $_POST['pn'];
                        $Address = $_POST['adr'];
                        if ($Password != $PasswordRepeat) {
                            echo '<script>alert("Password not mach!");</script>';
                        } else {
                            $checkUser = $conn->query("SELECT Username FROM members WHERE Username='$Username'");
                            try {
                                if ($checkUser->num_rows > 0) {
                                    echo '<script>alert("ERROR! Username is exist!, pleases use another Username");</script>';
                                } else {
                                    $PasswordSHA256 = hash('sha256', $Password);
                                    $PasswordHashBRYPTMD5 = password_hash($PasswordSHA256, PASSWORD_BCRYPT, ['cost' => 12]);
                                    $sql = "INSERT INTO members (Username, Password, TitleName, FirstName, LastName, Email, Address, PhoneNumber) ";
                                    $sql .= "VALUES ('$Username', '$PasswordHashBRYPTMD5', '$NameTitle', '$FirstName', '$LastName', '$Email', '$Address', '$PhoneNumber')";
                                    if ($conn->query($sql) == true) {
                                        echo '<script>alert("SUCCESS! Register success!");</script>';
                                        $Username = $Email = $NameTitle = $FirstName = $LastName = $PhoneNumber = $Address = "";
                                    } else {
                                        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
                                    }
                                }
                            } catch (Exception $e) {
                                echo '<script>alert("SQL ERROR!");</script>';
                            }
                        }
                    }
                    ?>
            <div style="width: 600px; margin:0 auto;">
                <form action="./register.php?token=<?php echo $_GET["token"] ?>" method="POST">
                    <div class="container">
                        <h1>Register</h1>
                        <p>Please fill in this form to create an account.</p>
                        <hr>

                        <label for="usn"><b>Username</b></label>
                        <input type="text" placeholder="Enter Username" name="usn" value="<?php echo $Username ?>" required>

                        <label for="psw"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="psw" required>

                        <label for="psw-repeat"><b>Repeat Password</b></label>
                        <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

                        <label for="email"><b>Email</b></label>
                        <input type="text" placeholder="Enter Email" name="email" value="<?php echo $Email ?>" required>

                        <hr>
                        <label for="tn"><b>Name Title</b></label>
                        <input type="text" placeholder="Enter Name Title" name="tn" value="<?php echo $NameTitle ?>" required>

                        <label for="fn"><b>First Name</b></label>
                        <input type="text" placeholder="Enter First Name" name="fn" value="<?php echo $FirstName ?>" required>

                        <label for="ln"><b>Last Name</b></label>
                        <input type="text" placeholder="Enter Last Name" name="ln" value="<?php echo $LastName ?>" required>

                        <label for="pn"><b>Phone Number</b></label>
                        <input type="text" placeholder="Enter Phone Number" name="pn" value="<?php echo $PhoneNumber ?>" required>

                        <label for="adr"><b>Address</b></label>
                        <textarea name="adr" rows="2" placeholder="Enter Address" required><?php echo $Address ?></textarea>
                        <button type="submit" class="registerbtn">Register</button>
                    </div>

                    <div class="container signin">
                        <p>Already have an account? <a href="./">Sign in</a>.</p>
                    </div>
                </form>
            </div>
        </body>

        </html>
<?php
    } else {
        echo 'TOKEN HAS EXPIRED';
    }
} else {
    echo 'TOKEN HAS EXPIRED';
}
?>