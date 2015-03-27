<?php
class ssh2 {

    function __construct($host, $user, $port, $password) { //() {
        $this->host = $host;
        $this->user = $user;
        $this->port = $port;
        $this->password = $password;
        
        $this->con = @ssh2_connect($this->host, $this->port);
     
        if(!$this->con) {
            die('Connection failed!');
        }
        else {
            $this->log .= "Connection success!\n";
            $this->authPassword();
        }
    }

    private function authPassword() {
        if( !@ssh2_auth_password( $this->con, $this->user, $this->password ) ) {
            die('Authorization failed!');
        }
        else
            $this->log .= "Login success!\n";
            return true;
    }

    public function sendExec( $command ) {

        $stream = @ssh2_exec($this->con, $command);
        $output = $this->readShell($stream);
    
        return $output;
    }

    private function readShell($stream) {
        // force PHP to wait for the output
        @stream_set_blocking($stream, true);
        
        // read the output into a variable
        $data = '';
        while($buffer = fread($stream, 4096)) {
            $data .= $buffer;
        }
        @fclose($stream);
        
        return $data;
    }

    public function getLog() {
        return $this->log;
    }

}

?>

<textarea style="width: 752px; height: 391px;"><?php
$host = '127.0.0.1';
$user = 'root';
$port = '22';
$password = 'MyRoootPass';

$obj = new ssh2($host, $user, $port, $password);
print_r($obj->sendExec('php -v'));

#print_r($obj->sendExec('touch /home/domain.conf'));
echo "\n\n\n\n";
#print_r($obj->sendExec("echo 'zone \"domain.conf\" IN {\ntype master;\nfile \"masters/drinfinity.de\";\nallow-update { none; }\n;};' > /home/domain.conf"));

print_r($obj->getLog());

?></textarea>





