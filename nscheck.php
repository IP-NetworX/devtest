<?php

$data = dns_get_record ( 'dima.de', DNS_ANY );

echo "<pre>";
print_r($data);
echo "</pre>";

echo "<hr />";

foreach ($data as $key => $server) {
    if (@$server['target'])
        $ns[$key] = $server['target'];
}

echo "<pre>";
print_r($ns);
echo "</pre>";

?>
<hr />