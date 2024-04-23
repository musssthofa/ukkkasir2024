<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login</title>
    <style>
        /* POPPINS FONT */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        *{
            font-family: 'Poppins', sans-serif;
        }
        body{
            background-image: url("logo.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .box{
            width: 350px;
            padding: 15px;
            background: rgba(255,255,255,0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,1.1);
        }
        .top-header{
            text-align: center;
            margin-bottom: 20px;
            position: center;
        }
        .top-header header{
            color: purple;
            font-size: 30px;
            position: center;
        }
        .input-field{
            position: relative;
            margin-bottom: 20px;
        }
        .input-field .input{
            height: 45px;
            width: 85%;
            border: none;
            outline: none;
            border-radius: 30px;
            color: black;
            padding: 0 0 0 42px;
            background: rgba(255,255,255,2.2);
        }
        i{
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: purple;
        }
        .submit{
            border: none;
            border-radius: 30px;
            font-size: 15px;
            height: 45px;
            outline: none;
            width: 100%;
            background: black;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        .submit:hover{
            background: #333;
        }
        .bottom{
            text-align: center;
        }
        .bottom label a{
            color: purple;
            text-decoration: none;
        }
    </style>
</head>
<body>
<?php
if(isset($_GET['pesan'])){
    if($_GET['pesan']=="gagal"){
        echo "<div class='alert' style='color: white; font-size: larger; text-align: center; margin-top: 20px;'>Username dan Password tidak sesuai !</div>";
    }
}
?>

    <form action ="cek_login.php" method= "POST" class="box">
        <div class="top-header">
            <header>Login</header>
        </div>
        <div class="input-field">
            <i class="bx bx-user"></i>
            <input type="text" class="input" placeholder="Username" name="username" required>
        </div>
        <div class="input-field">
            <i class="bx bx-lock-alt"></i>
            <input type="password" class="input" placeholder="Password" name="password" required>
        </div>
        <div class="input-field">
            <input type="submit" class="submit" value="Login">
        </div>
    </form>
</body>
</html>
