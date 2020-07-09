<?php
echo "<html>\n<head>\n";
if (isset($row) && array_key_exists("post_title", $row)) {
  echo "<title>" . $row["post_title"] . " :: " . $site_name . "</title>\n";
}
else {
  echo "<title>" . $site_name . "</title>\n";
}
echo "<link href=\"" . $theme_folder . "/style.css\" rel=\"stylesheet\" type=\"text/css\">\n";
echo "</head>\n<body>";
