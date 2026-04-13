<?php
include 'includes/travel-config.inc.php';

function getPDOConnection(): PDO {
    foreach ($GLOBALS as $value) {
        if ($value instanceof PDO) {
            $value->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $value;
        }
    }
    throw new Exception('No PDO connection found. Check includes/travel-config.inc.php');
}

$pdo = getPDOConnection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT i.ImageID, i.Title, i.Description, i.Path, i.Exif, i.Colors,
               i.ActualCreator, i.CreatorURL,
               c.AsciiName AS CityName,
               co.CountryName,
               u.FirstName, u.LastName
        FROM imagedetails i
        LEFT JOIN cities c
            ON i.CityCode = c.CityCode
        LEFT JOIN countries co
            ON i.CountryCodeISO = co.ISO
        LEFT JOIN users u
            ON i.UserID = u.UserID
        WHERE i.ImageID = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$image = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$image) {
    die('Image not found.');
}

$exif = [];
if (!empty($image['Exif'])) {
    $decoded = json_decode($image['Exif'], true);
    if (is_array($decoded)) {
        $exif = $decoded;
    }
}

$colors = [];
if (!empty($image['Colors'])) {
    $decoded = json_decode($image['Colors'], true);
    if (is_array($decoded)) {
        $colors = $decoded;
    }
}

$creatorName = trim(($image['FirstName'] ?? '') . ' ' . ($image['LastName'] ?? ''));
if ($creatorName === '') {
    $creatorName = $image['ActualCreator'] ?? 'Unknown';
}

$cityCountry = [];
if (!empty($image['CityName'])) {
    $cityCountry[] = $image['CityName'];
}
if (!empty($image['CountryName'])) {
    $cityCountry[] = $image['CountryName'];
}
$locationText = count($cityCountry) ? implode(', ', $cityCountry) : 'Unknown location';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chapter 14</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/styles.css" />
</head>

<body>
    <main class="detail">
        <div>
            <img src="images/travel/large/<?= htmlspecialchars($image['Path']) ?>"
                 alt="<?= htmlspecialchars($image['Title'] ?? 'Travel photo') ?>">
        </div>

        <div>
            <h1><?= htmlspecialchars($image['Title'] ?? 'Untitled') ?></h1>
            <h3><?= htmlspecialchars($locationText) ?></h3>
            <p><?= htmlspecialchars($image['Description'] ?? '') ?></p>

            <div class="box">
                <h3>Creator</h3>
                <?php if (!empty($image['CreatorURL'])) : ?>
                    <p>
                        <a href="<?= htmlspecialchars($image['CreatorURL']) ?>">
                            <?= htmlspecialchars($creatorName) ?>
                        </a>
                    </p>
                <?php else : ?>
                    <p><?= htmlspecialchars($creatorName) ?></p>
                <?php endif; ?>
            </div>

            <div class="box">
                <h3>Camera</h3>
                <p>Make: <?= htmlspecialchars((string)($exif['make'] ?? 'N/A')) ?></p>
                <p>Model: <?= htmlspecialchars((string)($exif['model'] ?? 'N/A')) ?></p>
                <p>Exposure: <?= htmlspecialchars((string)($exif['exposure_time'] ?? 'N/A')) ?></p>
                <p>Aperture: <?= htmlspecialchars((string)($exif['aperture'] ?? 'N/A')) ?></p>
                <p>Focal Length: <?= htmlspecialchars((string)($exif['focal_length'] ?? 'N/A')) ?></p>
                <p>ISO: <?= htmlspecialchars((string)($exif['iso'] ?? 'N/A')) ?></p>
            </div>

            <div class="box">
                <h3>Colors</h3>
                <?php if (count($colors) > 0) : ?>
                    <?php foreach ($colors as $color) : ?>
                        <div style="display:inline-block; margin:4px; text-align:center;">
                            <div style="width:40px; height:40px; background:<?= htmlspecialchars($color) ?>; border:1px solid #000;"></div>
                            <small><?= htmlspecialchars($color) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No color data available.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>
