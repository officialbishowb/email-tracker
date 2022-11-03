@php
$file = 'img/transparent.png';
$fp = fopen($file, 'rb');
header("Content-Type: image/png");
header("Content-Length: " . filesize($file));
// dump the picture and stop the script
fpassthru($fp);
exit;
@endphp