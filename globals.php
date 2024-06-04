<?php
session_start();
$BASE_URL = "http://".$_SERVER["SERVER_NAME"].":81".dirname($_SERVER["REQUEST_URI"]."?")."/";