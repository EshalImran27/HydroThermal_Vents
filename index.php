<?php
/**
 * Hydrothermal Vent Database - Home Page
 * Displays a list of all hydrothermal vents
 *
 * SET08101 Web Technologies Coursework Starter Code
 */
// Include the database connection file to access the getDbConnection() function
// This allows us to connect to the database and fetch the vent data to display on the homepage.
// The database connection details are stored in config.php, and the connection logic is in db.php.
require_once 'includes/db.php';

$pageTitle = 'Hydrothermal Vents';

// Fetch all vents from the database
// use trim to remove any whitespace from the input parameters and 
// filter_input to validate and sanitize the input data.

$pdo = getDbConnection();
$location = trim($_GET['location'] ?? '');
$type = trim($_GET['type'] ?? '');
$depth = trim($_GET['depth'] ?? '');

$discoveryYear = trim($_GET['discovery_year'] ?? '');
$mindepth = filter_input(INPUT_GET, 'mindepth', FILTER_VALIDATE_INT);
$maxdepth = filter_input(INPUT_GET, 'maxdepth', FILTER_VALIDATE_INT);
$minyear = filter_input(INPUT_GET, 'minyear', FILTER_VALIDATE_INT);
$maxyear = filter_input(INPUT_GET, 'maxyear', FILTER_VALIDATE_INT);

if($mindepth === false) {
    $mindepth = 0;
}
if($maxdepth === false) {
    $maxdepth = 10000;
}
if($minyear === false) {
    $minyear = 1000;
}
if($maxyear === false) {
    $maxyear = date('Y');
}
if($mindepth > $maxdepth) {
    [$mindepth, $maxdepth] = [$maxdepth, $mindepth];
}
if($minyear > $maxyear) {
    [$minyear, $maxyear] = [$maxyear, $minyear];
}
// use params array to store the parameters for the prepared statement, 
// this helps to prevent SQL injection attacks and also makes the code cleaner and easier to read.
// it helps send the instruction and the data separately so the database engine knows
// the difference between the code and the data, thus preventing malicious data from being executed as code.
$sql = 'SELECT id, name, location, type, depth_metres, discovery_year FROM vents';
$conditions = [];
$params = [];
if ($location !== '') {
    $conditions[] = 'location LIKE :location';
    $params[':location'] = '%' . $location . '%';
}
if ($type !== '') {
    $conditions[] = 'type = :type';
    $params[':type'] = $type;
}
if ($mindepth !== null && $maxdepth !== null) {
    $conditions[] = 'depth_metres BETWEEN :mindepth AND :maxdepth';
    $params[':mindepth'] = $mindepth;
    $params[':maxdepth'] = $maxdepth;
}
if ($minyear !== null && $maxyear !== null) {
    $conditions[] = 'discovery_year BETWEEN :minyear AND :maxyear';
    $params[':minyear'] = $minyear;
    $params[':maxyear'] = $maxyear;
}
//a conditional statement is used to check if there are any conditions to apply to the SQL query.
// if there are conditions, they are joined together with 'AND' and appended to the SQL query.
// this allows for dynamic filtering of the vents based on the user's input,
// making the search functionality more flexible and user-friendly.

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}
$sql .= ' ORDER BY name';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vents = $stmt->fetchAll();

// Fetch distinct vent types for the filter dropdown
$displayTypes = $pdo ->query('SELECT DISTINCT type FROM vents ORDER BY type');
$Types = $displayTypes->fetchAll(PDO::FETCH_COLUMN);

require_once 'includes/header.php';
?>
<div class="home-banner">
    <h1>Welcome to the Hydrothermal Vent Database</h1>
    <p>Discover the fascinating world of hydrothermal vents in the Western Pacific region.</p>
</div>
<div class="search-container">
<form class="search-form" method="get" action="search.php">
    <input type="text" name="q" placeholder="Search vents by name or location..." required>
    <button type="submit">Search</button>
</form>
<div class="filter-options">
    <button class="filter-button">Filter Results</button>
    <span id="active-filters"></span>
</div>
 <!-- the filter by location element is yet to be implemented, 
but the filter by type element is implemented and it fetches 
the distinct types from the database and displays them in a dropdown menu. -->
<form id="vent-filter-form" class="filters" method="get" action="index.php">
    <div class="dropdown">
        <p><strong>Filter by Location</strong></p>
        <div class="select">
            <span class="selected">Pacific Ocean</span>
            <div class="caret"></div>
        </div>
        <ul class="menu">
            <li>All</li>
            <li class="active">Pacific Ocean</li>
            <li>Atlantic Ocean</li>
            <li>India Ocean</li>
            <li>Arctic Ocean</li>
        </ul>
    </div>
    <div class="dropdown">
        <p><strong>Filter by Type</strong></p>
        <div class="select">
            <span class="selected">Back-arc Basin</span>
            <div class="caret"></div>
        </div>
        <ul class="menu">
            <li>All</li>
            <?php foreach ($Types as $type): ?>
                <li<?php if ($type === 'Back-arc Basin') echo ' class="active"'; ?>><?php echo e($type); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="sliders">
        <div class="slider-group">
            <label for="depth-slider"><strong>Depth (m):</strong></label>
            <input type="range" id="depth-slider" name="depth" min="0" max="5000" value="5000" step="100">
            <span id="depth-value">0 - 5000 m</span>
        </div>
        <div class="slider-group">
            <label for="discovery-year-slider"><strong>Discovery Year:</strong></label>
            <input type="range" id="discovery-year-slider" name="discovery_year" min="1977" max="<?php echo date('Y'); ?>" value="<?php echo date('Y'); ?>" step="1">
            <span id="discovery-year-value">1977 - <?php echo date('Y'); ?></span>
        </div>
    </div>
    <div class="filter-buttons">
        <button id="apply-filters" class="filter-button" type="submit">Apply Filters</button>
        <button id="clear-filters" class="filter-button" type="reset">Clear Filters</button>
    </div>
</div>
<?php if (empty($vents)): ?>
    <p>No vents found in the database.</p>
<?php else: ?>
<!-- //use of INT type casting to ensure that the id parameter is treated as an integer,
 which helps to prevent SQL injection attacks and also ensures that the correct data type
  is used when fetching the vent details. -->

<!-- had firstly added span location but towards end of the coursework I could have added it into the div parameter
    but didnt want to take the rist as anything might break at some point -->
<div class="cards">
    <?php foreach ($vents as $vent): ?>
        <div class="card" data-year="<?php echo (int)$vent['discovery_year']; ?>"
             data-depth="<?php echo (int)$vent['depth_metres']; ?>"
             data-type="<?php echo e($vent['type']); ?>">
            <h3><?php echo e($vent['name']); ?></h3>
            <span class="card-location" style="display: none;"><?php echo e($vent['location']); ?></span>
            <a class="card-link" id="each-detail" href="vent.php?id=<?php echo (int)$vent['id']; ?>">View Details</a>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
