<?php
$pageTitle = 'Global Vent Map';
require_once 'includes/header.php';
?>

<main class="map-page">
  <section class="map-description">
    <h2>Hydrothermal Vents Static Map</h2>
    <p>This map shows the locations of hydrothermal vents around the world, with a focus on the Western Pacific region. Each marker represents a known vent site, and the map provides a visual overview of vent distribution across the globe.</p>
    <p>Use this map to explore where hydrothermal vents are located and how they are distributed in relation to tectonic plate boundaries and oceanic features.</p>
  </section>
  <section class="map-image">
    <img src="images/map.png" alt="Global Map of Hydrothermal Vents">
    <p id="image-caption">Map data from NOAA.</p>
  </section>
</main>

<?php require_once 'includes/footer.php'; ?>