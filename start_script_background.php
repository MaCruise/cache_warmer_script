<?php
include('layout/head.php');
exec("start /B php /script_warmer/runscript.php");
redirect('websites.php');