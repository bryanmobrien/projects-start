<?php
include 'includes/travel-config.inc.php';

/*
 * Find the PDO connection created by travel-config.inc.php.
 * This makes the page a little more tolerant of whatever variable name
 * your instructor used in the config file.
 */
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

$continent = $_GET['continent'] ?? '0';
$country   = $_GET['country'] ?? '0';
$title     = trim($_GET['title'] ?? '');

/* Dropdown data */
$continentSql = "SELECT ContinentCode, ContinentName
                 FROM continents
                 ORDER BY ContinentName";
$continentStmt = $pdo->query($continentSql);
$continents = $continentStmt->fetchAll(PDO::FETCH_ASSOC);

$countrySql = "SELECT ISO, CountryName
               FROM countries
               ORDER BY CountryName";
$countryStmt = $pdo->query($countrySql);
$countries = $countryStmt->fetchAll(PDO::FETCH_ASSOC);

/* Main filtered gallery query */
$sql = "SELECT ImageID, Title, Path
        FROM imagedetails
        WHERE 1=1";
$params = [];

if ($continent !== '0') {
    $sql .= " AND ContinentCode = :continent";
    $params[':continent'] = $continent;
}

if ($country !== '0') {
    $sql .= " AND CountryCodeISO = :country";
    $params[':country'] = $country;
}

if ($title !== '') {
    $sql .= " AND Title LIKE :title";
    $params[':title'] = '%' . $title . '%';
}

$sql .= " ORDER BY Title";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <header>
        <form action="ch14-proj1.php" method="get">
            <div class="form-inline">
                <select name="continent">
                    <option value="0">Select Continent</option>
                    <?php foreach ($continents as $row) : ?>
                        <option value="<?= htmlspecialchars($row['ContinentCode']) ?>"
                            <?= ($continent === $row['ContinentCode']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['ContinentName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="country">
                    <option value="0">Select Country</option>
                    <?php foreach ($countries as $row) : ?>
                        <option value="<?= htmlspecialchars($row['ISO']) ?>"
                            <?= ($country === $row['ISO']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['CountryName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="text" placeholder="Search title" name="title"
                       value="<?= htmlspecialchars($title) ?>">

                <button type="submit" class="btn-primary">Filter</button>
                <a href="ch14-proj1.php" class="btn-secondary">Reset</a>
            </div>
        </form>
    </header>

    <main>
        <ul>
            <?php if (count($images) > 0) : ?>
                <?php foreach ($images as $img) : ?>
                    <li>
                        <a href="detail.php?id=<?= urlencode($img['ImageID']) ?>">
                            <img src="images/travel/square-medium/<?= htmlspecialchars($img['Path']) ?>"
                                 alt="<?= htmlspecialchars($img['Title'] ?? 'Travel photo') ?>">
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>No matching images found.</li>
            <?php endif; ?>
        </ul>
    </main>
</body>

</html>
