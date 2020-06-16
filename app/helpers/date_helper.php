<?php
// Make our dates look nice tou users
function friendlyDate($data){
     $convert = strtotime($data);
     $niceDate = '<time datetime="'.date('c').'">'.date('D, F j, Y, ', $convert). 'Week '.date('W', $convert).'</time>';
     return $niceDate;
}

function infoDate($data){
    $convert = strtotime($data);
    $niceDate = '<time datetime="'.date('c').'">'.date('M j, Y', $convert).'</time>';
    return $niceDate;
}

function weekOfMonth($when = null) {
    if ($when === null) $when = time();
    $week = strftime('%U', $when); // weeks start on Sunday
    $firstWeekOfMonth = strftime('%U', strtotime(date('Y-m-01', $when)));
    return 1 + ($week < $firstWeekOfMonth ? $week : $week - $firstWeekOfMonth);
}
