<form action="" method="post">
    string 1 : <input name="str1" type="text">
    <br>
    string 2 : <input name="str2" type="text">
    <br>
    string 3 : <input name="str3" type="text">
    <br>
    <input type="submit" name="submit" value="create">
</form>
<?php
$str1 = "";
$str2 = "";
$str3 = "";
$result = '';
if (isset($_POST['str1'])) {
    $str1 = $_POST['str1'];
}
if (isset($_POST['str2'])) {
    $str2 = $_POST['str2'];
}
if (isset($_POST['str3'])) {
    $str3 = $_POST['str3'];
}
$arr1 = str_split($str1);
$arr2 = str_split($str2);
$arr3 = str_split($str3);
for ($i = 0; $i < count($arr1); $i++) {
    $result = $result . $arr1[$i] . $arr2[$i] . $arr3[$i];
}
echo 'result is ' . $result . '<br><a href="../../index">home</a>';
?>