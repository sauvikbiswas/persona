<?php

// Begin configuration data : <edit this>
//
$site_persona = "works"; // name of the category that will be used to create the site
$site_name = "Sauvik Biswas: Works";
$theme_folder = "theme";
$landing_file = "landing.php";
$page_file = "page.php";
//
// End configuration data

// Begin fetching data from parent WP configuration
//
require('..' . DIRECTORY_SEPARATOR . 'wp-config.php' );
$id = $_GET["id"];
$servername = constant("DB_HOST");
$username = constant("DB_USER");
$password = constant("DB_PASSWORD");
$dbname = constant("DB_NAME");
//
//End fetching data

// Begin function definitions
//

// Fetch a single page based on the post_name (permalink)
$GLOBALS['site_persona'] = $site_persona;

function get_page_by_post_name($conn_ptr, $table_prefix, $post_name) {
    $sql="SELECT p.* FROM ".$table_prefix."posts p 
        INNER JOIN ".$table_prefix."term_relationships r ON r.object_id=p.ID 
            INNER JOIN ".$table_prefix."term_taxonomy t ON t.term_taxonomy_id = r.term_taxonomy_id 
            INNER JOIN ".$table_prefix."terms wt on wt.term_id = t.term_id 
        WHERE t.taxonomy='category' AND wt.slug='" . $GLOBALS['site_persona'] . "' AND p.post_type='page' AND p.post_status='publish' AND p.post_name='".$post_name."'";

    $result = $conn_ptr->query($sql);
    if ($result->num_rows == 0) return NULL;
    else {
        $row = $result->fetch_assoc();
        return $row;
    }
}

// Fetch the post_title and post_name
function get_post_list($conn_ptr, $table_prefix) {
    // Get a list of post_titles and  post_names and store them in an array
    $sql="SELECT p.ID, p.post_title, p.post_name, p.post_date, p.post_modified FROM ".$table_prefix."posts p 
        INNER JOIN ".$table_prefix."term_relationships r ON r.object_id=p.ID 
            INNER JOIN ".$table_prefix."term_taxonomy t ON t.term_taxonomy_id = r.term_taxonomy_id 
            INNER JOIN ".$table_prefix."terms wt on wt.term_id = t.term_id 
        WHERE t.taxonomy='category' AND wt.slug='" . $GLOBALS['site_persona'] . "' AND p.post_type='page' AND p.post_status='publish' ";

    $result = $conn_ptr->query($sql);
    $rows = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) 
        array_push($rows, $row);
    }

    // Enrich the array with tags
    $erows = [];
    foreach ($rows as $row) {
        $sql="SELECT wt.name, t.taxonomy FROM ".$table_prefix."posts p 
        INNER JOIN ".$table_prefix."term_relationships r ON r.object_id=p.ID 
            INNER JOIN ".$table_prefix."term_taxonomy t ON t.term_taxonomy_id = r.term_taxonomy_id 
            INNER JOIN ".$table_prefix."terms wt on wt.term_id = t.term_id 
        WHERE t.taxonomy='post_tag' AND p.ID='".$row["ID"]."'";
    
        $tags = [];
        $result = $conn_ptr->query($sql);
        if ($result->num_rows > 0) while ($wtrow = $result->fetch_assoc()) array_push($tags, $wtrow["name"]);
        $row["post_tags"]=$tags;
        array_push($erows, $row);
    }
    return $erows;
}
//
// End functions
 
// Create connection and publish
//
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, 'utf8');

// Publish site
if ($id != "") {
    require($theme_folder . DIRECTORY_SEPARATOR . $page_file);
}
else {
    require($theme_folder . DIRECTORY_SEPARATOR . $landing_file);
}

$conn->close();
//
// End connection
?>
