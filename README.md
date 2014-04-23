divia-totem
===========

Divia totem API PHP wrapper

Installation
-----
In composer, add a dependancy :
```
"require": {
    "vermi0ffh/divia-totem": ">=1.0.0"
}
```

Usage
-----

To retrieve all lines simply do :
```
$lignes = Totem::listerLignes();
```
The result is an array of Ligne objects.


To retrieve all stops of a line, do :
```
$arrets = $ligne->listerArrets();
```
The result is an array of Arret objects.

You can retrieve the next times a bus/tram will go by a stop with :
```
$horaires = $arret->getHoraires();
foreach($horaires as $horaire) {
    foreach($horaire->passages as $passage) {
        var_dump($passage);
    }
}
```