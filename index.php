<?php 
	$url = $_POST["url"];
?>

<form action="index.php" method="POST">
<input type="url" name="url" value="<?php echo $url ?>" size="60" /><input type="submit" value="Visualize" />
</form>
<hr />

<?php

if (isset($_POST["url"]) && strlen($_POST["url"]) > 0) {
	$contents = file_get_contents($url);

	while (strlen($contents) > 0) {
		if ($contents[0] == "\r") {
			echo "<span style='background:red;'>CR</span>";
			$contents = substr($contents, 1);
			continue;
		}
		if ($contents[0] == "\n") {
			echo "<span style='background:lime;'>LF</span><br />";
			$contents = substr($contents, 1);
			continue;
		}

		echo htmlspecialchars($contents[0]);
		$contents = substr($contents, 1);

		$lfIndex = strpos($contents, "\n");
		$crIndex = strpos($contents, "\r");
	}
	echo htmlspecialchars($contents);	
}

