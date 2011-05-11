<?php
require $cmsROOT.'scripts/config.php';
require $cmsROOT.'images/config.php';

$return = array();

//process the scripts
foreach($scripts as $k => $array){ $return[$k] = rewrite($array, 'scripts'); }

//and then the CSS
foreach($styles as $k => $array){ $return[$k] = rewrite($array, 'images'); }

return $return;

function rewrite($array, $dir){
	global $cmsROOT;
    $nArray = array();
    foreach($array as $s){ $nArray[] = $cmsROOT.$dir.'/'.$s; }
    return $nArray;
}
?>