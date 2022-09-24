<?php
require 'authentifier.php';

session_destroy();
header("Location: ../index.php");
