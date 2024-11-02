<?php require("functions.php") ?>

<?php
if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if (empty($username) ||  empty($password)) {
        $error = "Please Fill out all the fields";

    }

    $user = authenticateUser($_POST['username'], $_POST['password']);
    if ($user) {
            $success = "login Successful";
            session_start();
            $_SESSION['username'] = $_POST["username"];
            header("Location: create_topic.php");
            exit();
    } else {
            $error = "Login Failed!";
    }


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="logstyle.css" >
</head>
<body>
<header>
    <h1>Welcome to Vote Synerion</h1>
</header>

<main>
    <section>
        <h3> Login Form</h3><br>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username"  ><br>
            <label for="password">Password:</label>
            <input type="password" name="password"><br>
            <input type="submit" name="submit" value="Login">

        </form>

        <p ><?php if (isset($error)){echo $error; }?> </p>
        <p ><?php if (isset($success)){echo $success; }?> </p>

    </section>

    <p>Need To Register ? <a href="register.php">Register</a></p>
</main>

<footer>

</footer>


</body>
</html>



