<?php
$files = array_diff(scandir('rostros'), array('.', '..'));
echo json_encode(array_values($files));
?>
