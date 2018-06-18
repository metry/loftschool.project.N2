<?php
header('HTTP/1.1 404 Not Found');
header("Status: 404 Not Found");
?>
Sorry, Page is not found.
<?php if (APPLICATION_TYPE == 'log') {
    echo 'Произошла ошибка: <br>';
    echo 'Line:' . $e->getLine() . "<br>";
    echo 'File:' . $e->getFile() . "<br>";
    echo $e->getMessage() . "<br>";
    echo $e->getTraceAsString();
}
