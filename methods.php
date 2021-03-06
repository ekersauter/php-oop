<?php
/**
 * In class objectConstructor worden de `member` variabelen vanuit een associative array opgebouwd.
 * De conventies voor de naamgeving van functies binnen Symfony is camelCase.
 */
class objectsConstructor {
    public function __construct(Array $properties = array()) {
        foreach ($properties as $key => $value) {
            $this->{$key} = $value;
        }
    }
    function getItem($key) {
        if (isset($this, $key)) {
            return $this->$key;
        } else {
            die('Voor ' . $key . ' is er geen waarde in ' . $this);
        }
    }
}
/**
 * Generiek alle keys ophalen
 */
function getKeys($input) {
    reset($input);
    $startKey = key($input);
    $keys = array();
    foreach ($input->$startKey as $entry) $keys+= array_keys(get_object_vars($entry));
    return $keys;
}
/**
 * Haal de key op van het eerste item in $input
 */
function getFirstKey($input) {
    reset($input);
    $startKey = key($input);
    return $startKey;
}
/**
 * Alle eigenschappen van $objB toevoegen aan $objA
 */
function mergeObjects($objA, $objB) {
    foreach ($objB as $var => $value) {
        $objA->$var = $value;
    }
    return $objA;
}
/**
* Vetrekkende van een iteratie over $mappingArray is er een array_search in $objectsA en in $objectsB.
* Een var_dump komt vrij bij elke key - value mapping. 
*/
function mappedMerge($mappingArray, $objectsA, $objectsB) {
    foreach ($mappingArray as $mapArrays) {
        foreach ($mapArrays as $mapArray) {
            $firstMapKeyName = getFirstKey($mapArray);
            $mapFirstKeyValue = $mapArray[$firstMapKeyName];
            
            foreach ($objectsA as $objectA) {
                $key = array_search($mapFirstKeyValue, (array)$objectA);
                if ($key == $firstMapKeyName) {
                    $mappedMergedA = $objectA;
                    var_dump((array)$mappedMergedA);
                }
            }
            $secondMapKeyName = array_keys($mapArray) [1];
            $mapSecondKeyValue = $mapArray[$secondMapKeyName];
            
            foreach ($objectsB as $objectB) {
                $key = array_search($mapSecondKeyValue, (array)$objectB);
                if ($key == $secondMapKeyName) {
                    $mappedMergedB = $objectB;
                    var_dump(array_slice((array)$mappedMergedB, 0, 4));
                }
            }
            echo ('<hr>');
        }
    }
}
?>
