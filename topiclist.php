<?php require("functions.php");?>
<?php
    session_start();
    $username = getsession("username");
    $topics = getTopics();
    if(isset($_POST['up'])){
        $user =  vote($username,$_POST["topicID"],"up");
        if (!$user) {
            $error = "You Already Voted!";
        }


    }
    else if(isset($_POST['down'])){
       $user = vote($username,$_POST["topicID"],"down");
        if (!$user) {
            $error = "You Already Voted!";
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
    <link rel="stylesheet" href="appstyle.css">
</head>
<body>

<header>
    <h1>TOPICS</h1>
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



        <?php
        foreach($topics as $topic) {

            echo '<div class="topic" >';
            echo'<form action="" method="POST"> ';
            echo '<h2> Title: '.$topic["title"].'</h2>';

            echo $topic["description"].'<br>';
            echo '<br>';
            echo '<br>';
            $array = getVoteResults($topic["topicID"]);
            echo  $array["up"]." Upvotes  " ;
            echo  $array["down"]." Downvotes";
            echo '<input type="hidden" name="topicID" value="' . $topic["topicID"] . '">';
            echo '<button type = "submit" id="up" name="up" >Up Vote</button>';
            echo '<button type = "submit" id="down" name="down">Down Vote</button>';
            echo'</form> ';
            echo '</div>';
        }
        ?>




        <p><?php if (isset($error)){echo $error; }?> </p>

</main>

<footer>
    <p></p>
</footer>


</body>
</html>

