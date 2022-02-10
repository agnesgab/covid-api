
<?php
$from = $_GET['date-from'];
$to = $_GET['date-to'];

function getBetweenDates($startDate, $endDate): array
{
    $rangArray = [];

    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    for (
        $currentDate = $startDate;
        $currentDate <= $endDate;
        $currentDate += (86400)
    ) {

        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }

    return $rangArray;
}

$dates = getBetweenDates($from, $to);
?>

<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<h1>COVID-19 2020-2022</h1>
<div class="input-container">
<form method="get" action="/">
    <label>Datums no:</label>
    <input type="date" name="date-from" min="2020-01-01"
    >

    <label>Datums līdz:</label>
    <input type="date" name="date-to" min="2020-01-01">

    <div class="btn-container">
        <button type="submit">Meklēt</button>
    </div>
</form>
</div>
<table>
    <tr class="tbl-headings">
        <th class="date">Datums</th>
        <th class="number">Testu skaits</th>
        <th class="positive-num">Pozitīvo gadījumu skaits</th>
    </tr>
<?php foreach ($dates as $date): ?>
    <?php $q = json_decode(file_get_contents("https://data.gov.lv/dati/lv/api/3/action/datastore_search?q={$date}&resource_id=d499d2f0-b1ea-4ba2-9600-2c701b03bd4a"));
    foreach ($q->result->records as $record): ?>
    <tr>
        <?php $datums = explode('T', $record->Datums);
        if($datums[0] === $date): ?>
            <td>
            <?php echo $datums[0]; ?>
            </td>
        <td><?php echo $record->TestuSkaits;
            ?></td>
        <td><?php echo $record->ApstiprinataCOVID19InfekcijaSkaits;
            ?></td>
        <?php endif; ?>

    <?php endforeach;?>
        <?php endforeach;?>
</table>
</html>

