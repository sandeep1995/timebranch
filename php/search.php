<?php
include('db.php');
include('class.php');
$search_term = $_GET['query'];
$q->live_search($search_term);

?>