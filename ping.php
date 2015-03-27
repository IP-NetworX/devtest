<?php
/*
31.220.43.14
193.24.210.37
85.236.63.29
*/



$ips = array(
        '31.220.43.14',		    // ON line
		'193.24.210.37',	    // ON line
		'85.236.63.292',	    // OFF line
		'85.236.63.29',	        // ON line
		'85.236.63.27',	        // ON line
		'31.220.43.141',        // ON line / aber 403 Header
		'199.175.54.7',         // ON line / US
		'162.159.243.214',      // ON line / US Cloud
		'192.99.19.165',        // ON line / OVH Kanada
		'188.165.12.106',       // ON line / OVH France
		'81.91.170.12',         // On line / Denic
);


# ############# OPTION 1


function getHead($ip){
    $head = @get_headers('http://'.$ip);
    #$getHead[0]
    
    if ( preg_match("/200 OK/i", $getHead[0]) )
    	return true;
    else
    	return false;
    	
}

if ( getHead($ips[1]) )
	echo "Bist Online";
else
	echo "Bist Offline";

echo "<br />";
	
	
echo '<textarea style="width: 547px; height: 308px;">';
$getHead = @get_headers('http://'.$ips[1]);
print_r($getHead);
echo '</textarea>';




# ############# OPTION 2
echo "<hr />";



function pingIP($ip){
    $starttime = microtime(true);
    $file      = @fsockopen ($ip, 80, $errno, $errstr, 0.3); // 300ms Timeout
    $stoptime  = microtime(true);
    $status    = 0;

    if (!$file)
    	$status = -1;  // Site is down
    else {
        fclose($file);
        $status = ($stoptime - $starttime) * 1000;
        $status = floor($status);
    }
    return $status;
}

echo pingIP($ips[1]);

echo "<hr />";

foreach ($ips as $key => $ip) {
    
    $ping = pingIP($ip);
    echo '<p>'.$ip.' : ping '.$ping.' : ';
    if ($ping >= 0)
        echo 'ON';
    else
        echo 'OFF';
        
    echo '</p>';
}









?>