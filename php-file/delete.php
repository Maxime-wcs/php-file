<?php
if(isset($_GET['id'])) {
    unlink ('repertoire/'. $_GET['id'] );
    header( "location: index.php" );
}
