<?php

$line= $posts[0]['Post'];

$this->CSV->addRow(array_keys($line));
foreach ($posts as $post)
{ 
    $line= $post['Post'];
    $this->CSV->addRow($line);
}
//$filename='posts';
$filename = 'purchaseorder_details'; 
echo  $this->CSV->render($filename);
?>