<?php
session_start();
unset($_SESSION['login']['id_user']);
unset($_SESSION['role']);
header('location:index.php');