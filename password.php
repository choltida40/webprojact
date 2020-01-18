<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Encrypt Password</title>
    <style>
        code {
            background-color: #eee;
            border-radius: 3px;
            font-family: courier, monospace;
            padding: 0 3px;
        }

        .form-encrypt {
            text-align: center;
            margin: 0 auto;
        }
    </style>
    <script>
        function CopyToClipboard(containerid) {
            if (document.selection) {
                var range = document.body.createTextRange();
                range.moveToElementText(document.getElementById(containerid));
                range.select().createTextRange();
                document.execCommand("copy");

            } else if (window.getSelection) {
                var range = document.createRange();
                range.selectNode(document.getElementById(containerid));
                window.getSelection().addRange(range);
                document.execCommand("copy");
                alert("text copied")
            }
        }
    </script>
</head>

<body>
    <div class="form-encrypt">
        <form action="./password.php" method="GET">
            <?php
            $password = $PasswordHashBCRYPT = $PasswordSHA256 = $PasswordHashBCRYPTMD5 = "";
            if (isset($_GET["password"]) and $_GET["password"] != "") {
                $Password = $_GET["password"];
                $PasswordSHA256 = hash('sha256', $Password);
                $PasswordHashBCRYPT = password_hash($Password, PASSWORD_BCRYPT, ['cost' => 12]);
                $PasswordHashBCRYPTMD5 = password_hash($PasswordSHA256, PASSWORD_BCRYPT, ['cost' => 12]);
            } else {
                $Password = $PasswordHashBCRYPT = $PasswordSHA256 = $PasswordHashBCRYPTMD5 = "";
            }
            ?>
            <p>Password to encrypt:<input type="text" name="password" value="<?php echo $Password ?>"></p>
            <p>SHA256: <code><?php echo $PasswordSHA256; ?></code></p>
            <p>BCRYPT: <code><?php echo $PasswordHashBCRYPT; ?></code></p>
            <p>Password hashed: <code id="copyText"><?php echo $PasswordHashBCRYPTMD5 ?></code><button type="button" onclick="CopyToClipboard('copyText')">copy text</button></p>
            <input type="submit" value="Encrypt"><br>
            <i>Password encrypt as follows <b> PASSWORD => SHA-256 => BCRYPT => PASSWORD HASHED</b> </i>

        </form>
    </div>
</body>

</html>