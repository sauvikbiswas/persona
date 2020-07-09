<?php
require($theme_folder . DIRECTORY_SEPARATOR . 'header.php');

$post_list = get_post_list($conn, $table_prefix);
echo "<div class=\"post-title\"> " . $site_name . " </div>\n";
echo "<div class=\"post-content\">\n";
foreach($post_list as $post) {
    echo "<div>\n";
    echo " <span class=\"post-date-tag\">". date("d.m.Y", strtotime($post["post_date"])) ."</span>\n";
    echo "<span class=\"post-link\"><a href=\"?id=".$post["post_name"]."\">".$post["post_title"]."</a></span>\n";
    foreach($post["post_tags"] as $post_tag) echo " <span class=\"post-tag\">".strtolower($post_tag)."</span>\n";
    echo "</div>\n";
}
echo "</div>\n";

require($theme_folder . DIRECTORY_SEPARATOR . 'footer.php');
?>
