<?php
/**
 * Met json_decode wordt er een object aangemaakt met een array van objecten.
 */
$runnersJsonFile = file_get_contents(__DIR__ . "/runnersData.json");
$runnersData = json_decode($runnersJsonFile);
/**
 * Vanuit het json_decode-object kan met functie getFirstKey de naam van het eerste item
 * achterhaald worden en zo met `foreach` een associatieve array op te bouwen binnen de
 * keys en values structuur.
 * Vervolgens is er met objectsConstructor dynamisch een array van objecten aangemaakt.
 */
$firstKeyRunnersData = getFirstKey($runnersData);
$arrayOfKeysInRunnersData = getKeys($runnersData);
foreach ($runnersData->$firstKeyRunnersData as $row) {
    foreach ($row as $key => $value) {
        $propertyBuilder[$key] = $value;
    }
    $runners[] = new objectsConstructor($propertyBuilder);
    unset($propertyBuilder);
}
echo ('<h2>Aantal ' . $firstKeyRunnersData . ': ' . count($runnersData->$firstKeyRunnersData) . '</h2>');
echo ('Persoonsgegevens:');
for ($i = 0;$i < count($runners);++$i) {
    echo ('<hr>');
    foreach ($arrayOfKeysInRunnersData as $getName) {
        echo ($getName . ': ' . $runners[$i]->getItem($getName) . '<br>');
    }
}
echo ('<hr>');
/**
 * Nu gelijkaardig de objecten procedure uitwerken voor de `contest` gegevens
 */
$runnersJsonFile = file_get_contents(__DIR__ . "/runnersContestData.json");
$runnersContestData = json_decode($runnersJsonFile);
$firstKeyRunnersContestData = getFirstKey($runnersContestData);
$arrayOfKeysInRunnersContestData = getKeys($runnersContestData);
foreach ($runnersContestData->$firstKeyRunnersContestData as $row) {
    foreach ($row as $key => $value) {
        $propertyBuild[$key] = $value;
    }
    $runnersContests[] = new objectsConstructor($propertyBuilder);
    unset($propertyBuilder);
}
echo ('<h2>Aantal ' . $firstKeyRunnersContestData . ': ' . count($runnersContestData->$firstKeyRunnersContestData) . '</h2>');
/**
 * Ter referentie worden hieronder de `contest` gegevens weergegeven.
 */
for ($i = 0;$i < count($runnersContests);++$i) {
    echo ('<hr>');
    foreach ($arrayOfKeysInRunnersContestData as $getName) {
        echo ($getName . ': ' . $runnersContests[$i]->$getName . '<br>');
    }
}
echo ('<hr>');
/**
 * De objecten in het array kunnen nu positioneel gemerged worden met de functie `mergeObjects`.
 */
for ($i = 0;$i < count($runners);++$i) {
    $runnersMerge[] = mergeObjects($runnersContests[$i], $runners[$i]);
}
echo ('<h2>Positioneel samenvoegen van ' . $firstKeyRunnersData . ' en ' . $firstKeyRunnersContestData . '</h2>');
/**
 * Om nu zonder hard-coding uit een van de gemergde opjecten alle gegevens weer te geven
 * moeten de eerder opgebouwde key-arrays samengevoegd worden.
 * Hieronder komen alle gegevens uit het tweede object in $runnersMerge aan bod.
 */
$arrayOfKeysInRunnersMerge = array_merge($arrayOfKeysInRunnersData, $arrayOfKeysInRunnersContestData);
for ($i = 0;$i < count($runnersMerge);++$i) {
    echo ('<hr>');
    foreach ($arrayOfKeysInRunnersMerge as $getName) {
        echo ($getName . ': ' . $runnersMerge[$i]->$getName . '<br>');
    }
}
echo ('<hr>');
/*
 * Voor de juiste mapping van bijde objecten is onderstaande ter beschikking.
 * Dit maal is json_decode voorzien van een `true` waardoor $mappingArray in de vorm
 * van een array ter beschikking komt.
*/
echo ('<h2>Merging ' . $firstKeyRunnersData . ' en ' . $firstKeyRunnersContestData . ' op basis van de mapping in mapping.json</h2>');
echo ('<hr>');

$mappingFile = file_get_contents(__DIR__ . "/mapping.json");
$mappingArray = json_decode($mappingFile, true);
$mappingResult = mappedMerge($mappingArray, $runners, $runnersContests);
?>
