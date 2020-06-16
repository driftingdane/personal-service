<?php
function our_global_exception_handler($exception) {
    //this code should log the exception to disk and an error tracking system
    echo "Exception:" . $exception->getMessage();
}

set_exception_handler(‘our_global_exception_handler’);
