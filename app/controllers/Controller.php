<?php
require '../models/require.php';


$url = '../models/parameters.json'; // path to your JSON file
require_once ($url);

$data = file_get_contents(__DIR__ . '/' .$url); // put the contents of the file into a variable
$values1 = json_decode($data); // decode the JSON feed



Class Controller{
    private $model;

    public function __construct($model) {
    $this->model = $model;

        

}
    public function execute($model){
        $model->delete();
        $model->insert();
        $model->modify();
        $model->clone();
        $model->gettab();

    }

}
$model = new Model($values1);
$controller = new Controller($model);
$view1 = new View($controller, $model);


echo $view1->output();
$controller->execute($model);

