<?php
/**
 * Hydrothermal Vent Database - Home Page
 * Displays a list of all hydrothermal vents
 *
 * SET08101 Web Technologies Coursework Starter Code
 */
require_once 'includes/db.php';

$pageTitle = 'Hydrothermal Vents';

// Fetch all vents from the database
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
if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}
$sql .= ' ORDER BY name';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vents = $stmt->fetchAll();
$stmt = $pdo->query('SELECT DISTINCT type FROM vents ORDER BY type');
$types = $stmt->fetchAll(PDO::FETCH_COLUMN);


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
    <button class="filter-button">Filter by Type</button>
    <span id="active-filters"></span>
</div>
<div class="filters">
    <div class="dropdown">
        <p>Filter by Location</p>
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
        <p>Filter by Type</p>
        <div class="select">
            <span class="selected">Back-arc Basin</span>
            <div class="caret"></div>
        </div>
        <ul class="menu">
            <li>All</li>
            <li class="active">Back-arc Basin</li>
            <li>Mid-ocean Ridge</li>
            <li>Subduction Zone</li>
            <li>Volcanic Arc</li>
        </ul>
    </div>
    <div class="sliders">
        <div class="slider-group">
            <label for="depth-slider">Depth (m):</label>
            <input type="range" id="depth-slider" name="depth" min="0" max="5000" step="100">
            <span id="depth-value">0 - 5000 m</span>
        </div>
        <div class="slider-group">
            <label for="discovery-year-slider">Discovery Year:</label>
            <input type="range" id="discovery-year-slider" name="discovery_year" min="1977" max="<?php echo date('Y'); ?>" step="1">
            <span id="discovery-year-value">1977 - <?php echo date('Y'); ?></span>
        </div>
    </div>
    <div class="filter-buttons">
        <button id="apply-filters" class="filter-button">Apply Filters</button>
        <button id="clear-filters" class="filter-button">Clear Filters</button>
    </div>
</div>
<?php if (empty($vents)): ?>
    <p>No vents found in the database.</p>
<?php else: ?>
<div class="cards">
    <?php foreach ($vents as $vent): ?>
        <div class="card">
            <h3><?php echo e($vent['name']); ?></h3>
            <!-- <p><strong>Location:</strong> <?php echo e($vent['location']); ?></p>
            <p><strong>Type:</strong> <?php echo e($vent['type']); ?></p>
            <p><strong>Depth:</strong> <?php echo e($vent['depth_metres']); ?> m</p> -->
            <a class="card-link" href="vent.php?id=<?php echo e($vent['id']); ?>">View Details</a>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<script src="js/index.js"></script>

<?php require_once 'includes/footer.php'; ?>
