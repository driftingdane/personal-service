<?php
/// Helper function for downloads of pdf files
function downloadFile()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/public/pdf/';
        $file = $_GET['file'];
        $filehere = $dir . $file;

        if (file_exists($filehere) && is_readable($filehere) && preg_match('/\.pdf$/', $filehere)) {

            header('Content-Description: File Transfer');
            header('Content-type: application/pdf');
            header("Content-Disposition: inline; filename=\" $file\"");
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            ob_clean();
            flush();
            readfile($filehere);

            return true;

        } else {
            // Show errors
            return false;
        }
    }
}
