<?php require ("functions.php") ?>
<?php
session_start();
$username = getSession("username");
$votescast = getTotalVotesCast($username);
$topicCreated = getTopicTotalCreated($username);

$topics =  getUserVotingHistory($username);


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

<body >

<header>
    <h1> <?php echo $username."'s" ?> Profile Page</h1>
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
        <h3>Voting History : <?php echo $username ?> </h3>
        <br>
        <h4> Summary:  </h4>
        <?php
        echo 'Total Topics Created: '. $topicCreated;
        echo '<br>';
        echo 'Total Votes Casted: '. $votescast;
        ?>

        <h4> List of Topics Voted on:  </h4>
        <?php
        foreach($topics as $topic) {
            echo '<div class="topic">';
            echo '<h2> Title: '.$topic["title"].'</h2>';

            echo $topic["description"].'<br>';
            echo '<br>';
            echo '<br>';
            echo "Vote: ".$topic["vote"].'<br>';
            echo '</div>';
        }
        ?>
    </div>
</main>

<footer>
    <p></p>
</footer>


</body>
</html>

