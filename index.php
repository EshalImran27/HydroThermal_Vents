    <?php
    /**
     * Hydrothermal Vent Database - Home Page
     * Displays a list of all hydrothermal vents
     *
     * SET08101 Web Technologies Coursework Starter Code
     */
    require_once 'includes/db.php';

    $pageTitle = 'Hydrothermal Vents';

    $pdo = getDbConnection();

    // Read filters from query string
    $location = trim($_GET['location'] ?? '');
    $type = trim($_GET['type'] ?? '');
    $minDepth = filter_input(INPUT_GET, 'min_depth', FILTER_VALIDATE_INT);
    $maxDepth = filter_input(INPUT_GET, 'max_depth', FILTER_VALIDATE_INT);
    $yearFrom = filter_input(INPUT_GET, 'year_from', FILTER_VALIDATE_INT);
    $yearTo = filter_input(INPUT_GET, 'year_to', FILTER_VALIDATE_INT);

    if ($minDepth === false) {
        $minDepth = null;
    }
    if ($maxDepth === false) {
        $maxDepth = null;
    }
    if ($yearFrom === false) {
        $yearFrom = null;
    }
    if ($yearTo === false) {
        $yearTo = null;
    }

    if ($minDepth !== null && $maxDepth !== null && $minDepth > $maxDepth) {
        [$minDepth, $maxDepth] = [$maxDepth, $minDepth];
    }
    if ($yearFrom !== null && $yearTo !== null && $yearFrom > $yearTo) {
        [$yearFrom, $yearTo] = [$yearTo, $yearFrom];
    }

    // Build dynamic SQL query with prepared parameters
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
    if ($minDepth !== null) {
        $conditions[] = 'depth_metres >= :min_depth';
        $params[':min_depth'] = $minDepth;
    }
    if ($maxDepth !== null) {
        $conditions[] = 'depth_metres <= :max_depth';
        $params[':max_depth'] = $maxDepth;
    }
    if ($yearFrom !== null) {
        $conditions[] = 'discovery_year >= :year_from';
        $params[':year_from'] = $yearFrom;
    }
    if ($yearTo !== null) {
        $conditions[] = 'discovery_year <= :year_to';
        $params[':year_to'] = $yearTo;
    }

    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $sql .= ' ORDER BY name';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $vents = $stmt->fetchAll();

    // Populate type filter from database values
    $typeStmt = $pdo->query('SELECT DISTINCT type FROM vents ORDER BY type');
    $types = $typeStmt->fetchAll(PDO::FETCH_COLUMN);

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
    <div class="filter-btn-container">
        <button id="filter-toggle" class="filter-button">Toggle Filters</button>
    </div>
    <form id="vent-filter-form" class="filters" method="get" action="index.php">
        <div class="dropdown">
            <label for="location"><strong>Location contains</strong></label>
            <input type="text" id="location" name="location" value="<?php echo e($location); ?>" placeholder="e.g. Mariana, Fiji, Tonga">
        </div>
        <div class="dropdown">
            <label for="type"><strong>Vent type</strong></label>
            <select id="type" name="type">
                <option value="">All types</option>
                <?php foreach ($types as $dbType): ?>
                    <option value="<?php echo e($dbType); ?>" <?php echo $type === $dbType ? 'selected' : ''; ?>>
                        <?php echo e($dbType); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="sliders">
            <div class="slider-group">
                <label for="min_depth">Minimum depth (m)</label>
                <input type="number" id="min_depth" name="min_depth" min="0" step="1" value="<?php echo $minDepth !== null ? e((string) $minDepth) : ''; ?>">
            </div>
            <div class="slider-group">
                <label for="max_depth">Maximum depth (m)</label>
                <input type="number" id="max_depth" name="max_depth" min="0" step="1" value="<?php echo $maxDepth !== null ? e((string) $maxDepth) : ''; ?>">
            </div>
        </div>
        <div class="sliders">
            <div class="slider-group">
                <label for="year_from">Discovery year from</label>
                <input type="number" id="year_from" name="year_from" min="1900" max="<?php echo date('Y'); ?>" step="1" value="<?php echo $yearFrom !== null ? e((string) $yearFrom) : ''; ?>">
            </div>
            <div class="slider-group">
                <label for="year_to">Discovery year to</label>
                <input type="number" id="year_to" name="year_to" min="1900" max="<?php echo date('Y'); ?>" step="1" value="<?php echo $yearTo !== null ? e((string) $yearTo) : ''; ?>">
            </div>
        </div>
        <div class="filter-buttons">
            <button id="apply-filters" class="filter-button" type="submit">Apply Filters</button>
            <a id="clear-filters" class="filter-button" href="index.php">Clear Filters</a>
        </div>
    </form>
    <?php if (empty($vents)): ?>
        <p>No vents found for the selected filters.</p>
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
