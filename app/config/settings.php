<?php
//Define DB credentials
define("DB_HOST", "192.168.50.6");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "reservationsystem");

//Define paths
define("INCLUDES_PATH", __DIR__ . "/../");
define("RESOURCES_PATH", "public/");
define("LOG_PATH", "../app/logs/");
define("IMAGES_PATH", "images");
define("LOGO_PATH", IMAGES_PATH . "/vollingo-logo.png");
define("BASE_PATH", "/");

//Define necessary constants for this project
define('MIN_YEAR', 2018); //The minimum displayable year
define('MAX_YEAR', 2050); //The maximum displayable year
define("SEASON_START", 12); //First week of the beach volleyball season
define("SEASON_END", 24); //Last week of the beach volleyball season
define("STANDARD_BLOCK_LENGTH", 1); //Standard length of a time block
define("DAY_START", 7); //The start of the displayed day (takes hours)
define("DAY_END", 22); //The end of the displayed day (takes hours)

//Custom error handler, so every error will throw a custom ErrorException
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, $severity, $severity, $file, $line);
});
