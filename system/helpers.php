<?php

function ensureLoggedIn() {
	if ($_SESSION['sessionCheck'] != 'true') {
		session_destroy();
		header("location:login.php");
	}
}