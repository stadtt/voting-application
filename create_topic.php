<?php require("functions.php") ?>
<?php
    session_start();

    if(isset($_POST['submit'])) {
    if (trim(empty($_POST['topic'])) || empty(trim($_POST['description']))) {
        $error = "Please Fill out all the fields";
    }else {

        $username = $_SESSION["username"];
        $topic = $_POST['topic'];
        $description = $_POST["description"];

        $user = createTopic($username, $topic, $description);
        if ($user) {
            header("Location: topiclist.php");
            exit();
        }
    }
}
if($_SERVER['REQUEST_METHOD'] === "POST"){
    if (isset($_POST['dark'])) {
        setSession('theme', 'dark');
    }
    else if(isset($_POST['light'])){
        setSession('theme', 'light');

    }
    set_cookie("theme", getSession('theme'));
}
$theme = getSession('theme') ? $_SESSION['theme'] : 'light';


?>
<!DOCTYPE html>
<html lang="en" class="<?php echo $theme; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="appstyle.css"">
</head>
<body>

    <header>
        <h1>Welcome to My dashboard</h1>
    </header>
    <nav>
        <form method="post" action="">
            <button type="submit" name="light"> Light </button>
            <button type="submit" name="dark"> Dark </button>
        </form>
    </nav>

    <main>
        <section>
            <a href="topiclist.php">TOPICS </a>
            <a href="profile.php">Profile </a>
            <a href="index.php">LOG OUT </a>
            <a href="create_topic.php">DASHBOARD </a>
        </section>


        <div>
            <form action="" method="post">
                <label for="topic">TOPIC:</label>
                <input type="text" name="topic">
                <label for="description"> Description:</label>
                <textarea name="description" rows="300" cols="300"></textarea>
                <input type="submit" name="submit">

            </form>
            <p><?php if (isset($error)){echo $error; }?> </p>

        </div>
    </main>

    <footer>
        <p></p>
    </footer>


</body>
</html>