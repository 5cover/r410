<?php
use CodeIgniter\HTTP\Exceptions\HTTPException;

assert ($e instanceof HTTPException);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $e->getCode() ?></title>
</head>
<body>
    <p><?= esc($e->getMessage()) ?> : error <?= $e->getCode() ?></p>
</body>
</html>