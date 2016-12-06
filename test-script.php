<?php

require('vendor/autoload.php');

$creatures = (new Timongo\Creatures\FileCreaturesRepository)->checkImages();

var_dump($creatures);