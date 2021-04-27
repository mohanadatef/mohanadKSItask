<?php
$array = array(4,4, 3,2,3,2,5, 3, 15, 3, 9, 5, 7, 9, 7);
for($i=0;$i<count($array);$i++)
{
    $counts = array_count_values($array);
    if($counts[$array[$i]] == 1)
    {
        echo  $array[$i];
    }
}
echo '<br><a href="../../index">home</a>';
