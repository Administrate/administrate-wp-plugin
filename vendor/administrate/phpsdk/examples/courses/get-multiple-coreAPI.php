<?php

header('Content-Type: application/json');

require_once '../config.php';
require_once '../../vendor/autoload.php';

use Administrate\PhpSdk\Course;

// $categoryId Set this value in config.php
// $coreApiActivationParams Set this value in config.php
// $return type defined in client Class 'array' -> PHP array, 'obj' -> PHP Object and 'json' -> JSON

$courseClass = new Course($coreApiActivationParams);

$keyword = "Template 3";

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
        //     "value" => "%".$keyword."%"
        // )
    ),
    'paging' => array(
        'page' => 1,
        'perPage' => 50
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
    'fields' => array(
        'id',
        'legacyId',
        'lifecycleState',
        'code',
        'title',
        'events' => array(
            'type' => 'edges',
            'filtersType' => 'EventFieldGraphFilter',
            'filters' => array(
                array(
                    'field' => 'status',
                    'operation' => 'eq',
                    'value' => 'Active'
                ),
            ),
            'fields' => array(
                'id',
                'title',
                'price',
                'status',
                'location' => array('id', 'name')
            )
        ),
    )
);

$allCourses = $courseClass->loadAll($args);

print_r($allCourses);
