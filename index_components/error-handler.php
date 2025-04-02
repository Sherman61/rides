<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);



// Function to log errors to a file
function logError($errorMessage) {
    $logFile = 'logs/error_log.txt';
    $timestamp = date("Y-m-d H:i:s");
    $errorEntry = "[$timestamp] ERROR: $errorMessage" . PHP_EOL;
    echo "If you see this message, there's an error the developer needs to fix. Sorry!"; 
    file_put_contents($logFile, $errorEntry, FILE_APPEND);
}

// Custom error handler function
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $errorMessage = "Error [$errno]: $errstr in $errfile on line $errline";
    logError($errorMessage);

    // Display error message in a Bootstrap alert
    echo "<div class='alert alert-danger' role='alert'>$errorMessage</div>";

    return true; // Prevents the default PHP error handler from running
});

// Custom exception handler function
set_exception_handler(function ($exception) {
    $errorMessage = "Exception: " . $exception->getMessage();
    logError($errorMessage);

    echo "<div class='alert alert-warning' role='alert'>$errorMessage</div>";
});
?>
