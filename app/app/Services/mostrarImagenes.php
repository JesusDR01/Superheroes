<?php
echo <<<EOD
<div>
<a href="javascript:history.back()">Volver</a>
</div>
EOD;

define("DIRUPLOAD",'upload/');

$myfiles = array_diff(scandir(DIRUPLOAD), array('.', '..')); 
array_walk($myfiles, function(&$value, $key) {
    $value = DIRUPLOAD . $value;
    echo <<<EOD
    <div>
    <img src={$value} alt="Imagen subida por el usuario"></img>
    </div>
    EOD;
});

?>