<?php

header('Content-Type: application/json');

require_once '../config.php';
require_once '../../vendor/autoload.php';

use Administrate\PhpSdk\Catalogue;

// $categoryId Set this value in config.php
// $coreApiActivationParams Set this value in config.php
// $return type defined in client Class 'array' -> PHP array, 'obj' -> PHP Object and 'json' -> JSON

$catalogueClass = new Catalogue($coreApiActivationParams);

$args = array(
    'filters' => array(
        // array(
        //     "field" => "learningCategoryId",
        //     "operation" => "eq",
        //     "value" => $categoryId
        // ),
        // array(
        //     "field" => "name",
        //     "operation" => "like",
        //     "value" => "%".$searchKeyword."%"
        // )
    ),
    //'search' => $searchKeyword,
    // 'customFieldFilters' => array(
    //     array(
    //         "id" => $customFieldId,
    //         "operation" => "eq",
    //         "value" => $customFieldValue
    //     ),
    // ),
    'paging' => array(
        'page' => 1,
        'perPage' => 10
    ),
    'sorting' => array(
        'field' => 'name',
        'direction' => 'asc'
    ),
    'returnType' => 'json', //array, obj, json
    // 'fields' => array(
    //     'id',
    //     'name'
    // ),
    'coreApi' => true,
);

$catalogue = $catalogueClass->loadAll($args);

print_r($catalogue);
