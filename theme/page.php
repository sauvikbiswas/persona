<?php
$row = get_page_by_post_name($conn, $table_prefix, $id);

require($theme_folder . DIRECTORY_SEPARATOR . 'header.php');

if ($row!=NULL) {
    echo "<div class=\"post-back\"><a href=\"?\">" . $site_name . "</a></div>\n";
    echo "<div class=\"post-title\">" . $row["post_title"]. "</div>\n";
    echo "<div class=\"post-content\">" . $row["post_content"]. "</div>\n";
}
else {
    echo "<div class=\"post-title\">Something is missing</div>\n";
    echo "<div class=\"post-content\">Are your sure you wanted to land here?<br> <a href=\"?\">Take me home</a></div>\n";
}

require($theme_folder . DIRECTORY_SEPARATOR . 'footer.php');
?>
