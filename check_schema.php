<?php
$c = DB::select('describe properties');
foreach ($c as $r) {
    echo $r->Field . ' | ' . $r->Type . PHP_EOL;
}
