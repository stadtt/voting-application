<?php
function ifUserExist($username) {

    $file = "users.txt";
    if(!file_exists($file)){
        touch($file);
    }

    $names = [];
    $lines = file($file);

    foreach($lines as $line) {
        list($currentNames, $password) = explode(':', trim($line));
            $names[] = $currentNames;
    }

    return in_array($username, $names);
}

function registerUser($username,$password){
    $file = "users.txt";
    if(!file_exists($file)){
        touch($file);
    }

    $password = trim($password);
    $username = trim($username);
    if(ifUserExist($username)) {
        return false;
    }
    $data = $username.':'.$password.PHP_EOL;
    file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

    return true;
}


function authenticateUser($username, $password)
{
    $username = trim($username);
    $password = trim($password);
    $file = "users.txt";
    if(!file_exists($file)){
        touch($file);
    }
    $lines = file($file);

    foreach ($lines as $line) {
        list($currentnames, $currentpassword) = explode(':', trim($line));

        if ($currentnames == $username && $password == $currentpassword) {
            return true;
        }
    }

    return false;
}



function createTopic($username,$title,$description){
    $file = "topics.txt";
    if(!file_exists($file)){
        touch($file);
    }
    $topicID = getID();
    $data = $topicID."|".$username."|".$title."|".$description.PHP_EOL;
    if(file_put_contents($file,$data,FILE_APPEND)){
        return true;
    }
    else{
        return false;
    }
}

function getID(){
    $file = "ids";
    if(!file_exists($file)){
        touch($file);
        $handle = fopen($file,"r+");
        $id = 0;

    }else{
        $handle = fopen($file,'r+');
        $id = fread($handle, filesize($file));
        settype($id ,"integer");
    }
    rewind($handle);
    fwrite($handle, ++$id);
    fclose($handle);
    return $id;

}

function getTopics(){

    $file = "topics.txt";
    if(!file_exists($file)){
        touch($file);
    }
    $line = file($file);
    $newArray = [];
    foreach($line as $lines){
        list($topicID, $username,$title,$description) = explode("|" , $lines);
        $newArray[] = ["topicID" => $topicID,
                      "creator"=> $username,
                      "title" => $title,
                      "description" => $description ];

    }

    return $newArray;

}

function vote($username, $topicID, $voteType){

    $file = "votes.txt";
    if(!file_exists($file)){
        touch($file);
    }
    $data = "$username"."|".$topicID."|".$voteType.PHP_EOL;
    if(!hasVoted($username, $topicID)){
       return file_put_contents($file,$data,FILE_APPEND);
    }
    else{
        return false;
    }
}

function hasVoted($username, $topicID)
{
    $file = "votes.txt";
    if(!file_exists($file)){
        touch($file);
    }
    $line = file($file);
    foreach($line as $lines){
        list($name,$voteID ,$currentvote) = explode("|" , $lines);
        if($name == $username && $topicID == $voteID){
            return true;
        }

    }
    return false;
}


function getVoteResults($topicID){
    $file = "votes.txt";
    if(!file_exists($file)){
        touch($file);
    }
    $line = file($file);
    $upcounter = 0;
    $downcounter = 0;

    foreach($line as $lines){
        list($name,$voteID ,$currentvote) = explode("|" , trim($lines));
        if($currentvote == "up" && $topicID == $voteID){
            ++$upcounter;
        }

    }
    foreach($line as $lines){
        list($name,$voteID ,$currentvote) = explode("|" , trim($lines));
        if($currentvote == "down" && $topicID == $voteID){
            ++$downcounter;
        }

    }
    return ["up" => $upcounter, "down" => $downcounter];


}

function getUserVotingHistory($username){
    $file = "votes.txt";
    if(!file_exists($file)){
        touch($file);
    }
    $votesArray = getTopics();

    $line = file($file);
    $newArray = [];
    $line = file($file);
    foreach($line as $lines){
        list($name,$voteID ,$currentvote) = explode("|" , trim($lines));
        if ($name == $username){
            foreach($votesArray as $vote) {
                if($voteID == $vote['topicID']) {
                     $newArray[] = [ "id" => $voteID,
                                    "vote" => $currentvote,
                                    "title" => $vote['title'],
                                    "description" => $vote['description']
                                    ];
                         }
                 }

        }
    }
    return $newArray;

}

function getTopicsByUser($username){
    $file = "topics.txt";
    if(!file_exists($file)){
        touch($file);
    }
    $line = file($file);
    $newArray = [];

    foreach($line as $lines) {
        list($topicID, $name, $title, $description) = explode("|", $lines);
        if ($name == $username) {
            $newArray[] = ["topicID" => $topicID,
                "title" => $title,
                "description" => $description];

        }
    }
    return $newArray;
}

function getTotalVotesCast($username){
    $file = "votes.txt";
    if(!file_exists($file)){
            touch($file);
    }
    $line = file($file);
    $counter = 0;
    foreach($line as $lines){
        list($name,$voteID ,$currentvote) = explode("|" , trim($lines));
        if ($name == $username){
            ++$counter;
        }
    }
    return $counter;
}


function getTopicTotalCreated($username){
    $array = getTopicsByUser($username);
    $arraylen = sizeof($array);
    return $arraylen;
}


function set_cookie($key, $value)
{
    if (php_sapi_name() == 'cli') {
        $_COOKIE[$key] = $value;

    }
    else {
        setcookie($key, $value, time() + 46000);

    }
    return true;
}

function getCookie($key){

    return $_COOKIE[$key];

}

function setSession($key, $value)
{
    $_SESSION[$key] = $value;
    if(isset($_SESSION[$key])){
        return true;
    }
    return false;
}

function getSession($key)
{
    return $_SESSION[$key];
}

