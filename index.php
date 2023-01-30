<?php 
	$url = $_GET["url"];
	$urlEscaped = htmlspecialchars($url);
?>

<form action="" method="GET">
<input type="url" name="url" value="<?php echo $urlEscaped ?>" size="60" /><input type="submit" value="Visualize" />
&nbsp;
Legend: <span style='font-family: monospace;'><span style='background:red;'>CR</span> <span style='background:lime;'>LF</span> <span style='background:cyan;'>LSEP</span> <span style='background:orange;'>PSEP</span> <span style='background:magenta;'>NEL</span></span>
</form>
<hr />

<?php

if (isset($_GET["url"]) && strlen($_GET["url"]) > 0) {
	$contents = file_get_contents($url);

	echo "<div style='font-family: monospace; line-break: anywhere;'>";
	while (mb_strlen($contents) > 0) {
		if ($contents[0] == "\r" && $contents[1] == "\n") {
			echo "<span style='background:red;'>CR</span><span style='background:lime;'>LF</span><br />";
			$contents = mb_substr($contents, 2);
			continue;
		}
		if ($contents[0] == "\r") {
			echo "<span style='background:red;'>CR</span><br />";
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

		$sublength = mb_strlen($contents);
		$crIndex = mb_strpos($contents, "\r");
		if ($crIndex != false && $crIndex < $sublength) {
			$sublength = $crIndex;
		}
		$lfIndex = mb_strpos($contents, "\n");
		if ($lfIndex != false && $lfIndex < $sublength) {
			$sublength = $lfIndex;
		}
		$tabIndex = mb_strpos($contents, "\t");
		if ($tabIndex != false && $tabIndex < $sublength) {
			$sublength = $tabIndex;
		}
		$spaceIndex = mb_strpos($contents, " ");
		if ($spaceIndex != false && $spaceIndex < $sublength) {
			$sublength = $spaceIndex;
		}
		$lsepIndex = mb_strpos($contents, "\xE2\x80\xA8");
		if ($lsepIndex != false && $lsepIndex < $sublength) {
			$sublength = $lsepIndex;
		}
		$psepIndex = mb_strpos($contents, "\xE2\x80\xA9");
		if ($psepIndex != false && $psepIndex < $sublength) {
			$sublength = $psepIndex;
		}
		$nelIndex = mb_strpos($contents, "\xC2\x85");
		if ($nelIndex != false && $nelIndex < $sublength) {
			$sublength = $nelIndex;
		}

		echo htmlspecialchars(mb_substr($contents, 0, $sublength));
		$contents = mb_substr($contents, $sublength);
	}
	echo htmlspecialchars($contents);
	echo "</div>";
}

