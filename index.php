<?php

$connect = mysqli_connect(
    'db',
    'mini',
    'password',
    'mini'
);

$tb_name = 'content';

$query = "SELECT * FROM $tb_name";

$response = mysqli_query($connect,$query);

echo "<strong>$tb_name</strong>";
while($i = mysqli_fetch_assoc($response))
{
    echo "<p>".$i['text']."</p>";
    echo "<p>".$i['body']."</p>";
    echo "<p>".$i['created_at']."</p>";
    echo "<hr>";
}

?>