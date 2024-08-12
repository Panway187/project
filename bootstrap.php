<?php

require_once realpath(__DIR__ . '/config.php');

require_once realpath(__DIR__ . '/ParentModel.php');

require_once realpath(__DIR__ . '/ParentController.php');

//require_once realpath(__DIR__ . '/TModel.php');

//require_once realpath(__DIR__ . '/TController.php');

require_once realpath(__DIR__ . '/WeatherModel.php');

require_once realpath(__DIR__ . '/ControllerWeather.php');


//new bot\TController();

new bot\ControllerWeather();
