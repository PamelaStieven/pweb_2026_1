<?php
require_once("../auth/auth.php");
require_once("../database/db.class.php");

$db = new db("livros");

$db->destroy($_GET['id']);

header("Location: index.php");