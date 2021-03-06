<?php

/* @var \Codeception\Scenario $scenario */
$scenario->groups(['tasks', 'delete']);

$guy = new TestGuy($scenario);
$guy->wantTo('delete a task');

// delete a task
$guy->sendDELETE('/task/1');
$guy->seeResponseIsJson();
$guy->seeResponseContainsJson([
    'code' => 0,
]);
$guy->seeResponseContains('"message":');

// delete a non existing task
$guy->sendGET('/task/1');
$guy->seeResponseIsJson();
$guy->seeResponseContainsJson([
    'code' => 1
]);
$guy->seeResponseContains('"message":');