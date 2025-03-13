<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table>
        <thead>
            <tr>
            <th>Request</th>
            <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Le nombre de villes par pays</td>
                <td><table>
                    <thead>
                        <tr>
                            <th>Pays</th>
                            <th>Nombre de villes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($q1 as $row) { ?>
                            <tr>
                                <td><?= esc($row->country) ?></td>
                                <td><?= $row->n_cities ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table></td>
            </tr>
            <tr>
                <td>Le nombre de pays par continent</td>
                <td><table>
                    <thead>
                        <tr>
                            <th>Continent</th>
                            <th>Nombre de pays</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($q2 as $row) { ?>
                            <tr>
                                <td><?= esc($row->continent) ?></td>
                                <td><?= $row->n_countries ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table></td>
            </tr>
            <tr>
                <td>Le nombre de villes par continent</td>
                <td><table>
                    <thead>
                        <tr>
                            <th>Continent</th>
                            <th>Nombre de villes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($q3 as $row) { ?>
                            <tr>
                                <td><?= esc($row->continent) ?></td>
                                <td><?= $row->n_cities ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table></td>
            </tr>
            <tr>
                <td>Le nombre maximum de villes par pays </td>
                <td><?= esc($q4->country) ?>, <?= $q4->n_cities ?> villes</td>
            </tr>
            <tr>
                <td>Le nombre moyen de villes par continent</td>
                <td><?= round($q5->avg) ?></td>
            </tr>
            <tr>
                <td>Le nombre maximum de pays par continent</td>
                <td><?= esc($q6->continent) ?>, <?= $q6->n_countries ?> pays</td>
            </tr>
        </tbody>
    </table>
</body>
</html>