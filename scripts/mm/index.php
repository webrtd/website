<?php

echo "<center>PHP Mass Mail</center>";

echo "<form method=post action='send.php' enctype='multipart/form-data'>";

echo "from: <input name='from' size='30' maxlength='30'><br>";
echo "name: <input name='who' size='30' maxlength='30'><br><br>";
echo "subject: <input name='subject' size='30' maxlength='30'><br><br>";

echo "to:<br><textarea name='to' cols=60 rows=15></textarea><br>";

echo "message:<br><textarea name='message' cols=60 rows=15></textarea><br>";

/*
//upload images
$max_no_img=5; // Maximum number of images value to be set here
//echo "<form method=post action='attach.php' enctype='multipart/form-data'>";
for ($i=1; $i<=$max_no_img; $i++){
echo "<tr><td>File $i: </td><td>
<input type=file name='file[]' class='bginput'></td></tr><br>";}
//*/

echo "<input type=file name='userfile[]' class='bginput'>";

echo "<input type='submit' value='Send mail'>";

echo "</form>";

?>
