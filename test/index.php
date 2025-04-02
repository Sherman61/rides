<!DOCTYPE html>
<html lang="en">
<?php
include 'index_components/error-handler.php';
include 'index_components/index_sql.php';

include 'index_components/header.php';
?>

<body>
    <?php
    include 'index_components/nav-bar.php';
    // Filter Dropdown plus some more?
    include_once 'index_components/filter-dropdown.php';
    include_once 'index_components/search-bar.php';
    ?>
    <br />
    <?php
    include 'index_components/ride-list.php';
    include_once "footer.php";
    ?>

    <script src="index_components/index.js"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>