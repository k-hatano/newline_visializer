<?php 
	$url = $_GET["url"];
	$urlEscaped = htmlspecialchars($url);
?>

<form action="" method="GET">
<input type="url" name="url" value="<?php echo $urlEscaped ?>" size="60" /><input type="submit" value="Visualize" />
</form>
<hr />

<?php

if (isset($_GET["url"]) && strlen($_GET["url"]) > 0) {
	$contents = file_get_contents($url);

	while (mb_strlen($contents) > 0) {
		if ($contents[0] == "\r") {
			echo "<span style='background:red;'>CR</span>";
			$contents = mb_substr($contents, 1);
			continue;
		}
		if ($contents[0] == "\n") {
			echo "<span style='background:lime;'>LF</span><br />";
			$contents = mb_substr($contents, 1);
			continue;
		}
		if ($contents[0] == "\t") {
			echo "&emsp;";
			$contents = mb_substr($contents, 1);
			continue;
		}
		if ($contents[0] == " ") {
			echo "&nbsp;";
			$contents = mb_substr($contents, 1);
			continue;
		}
		if ($contents[0] == "\xE2" && $contents[1] == "\x80" && $contents[2] == "\xA8") {
			echo "<span style='background:cyan;'>LSEP</span>";
			$contents = mb_substr($contents, 3);
			continue;
		}
		if ($contents[0] == "\xE2" && $contents[1] == "\x80" && $contents[2] == "\xA9") {
			echo "<span style='background:orange;'>PSEP</span>";
			$contents = mb_substr($contents, 3);
			continue;
		}
		if ($contents[0] == "\xC2" && $contents[1] == "\x85") {
			echo "<span style='background:magenta;'>NEL</span>";
			$contents = mb_substr($contents, 2);
			continue;
		}

		echo htmlspecialchars(mb_substr($contents, 0, 1));
		$contents = mb_substr($contents, 1);
	}
	echo htmlspecialchars($contents);	
}

