<?php


class View
{
private $model;
private $controller;

public function __construct($controller,$model) {
$this->controller = $controller;
$this->model = $model;
}

public function output(){


echo <<<_END
<div class = "test1">
<form action="" method="post" name="basic"><pre>
  Auteur <input type="text" name="auteur">
   Titre <input type="text" name="titre">
Catégorie <input type="text" name="categorie">
   Année <input type="text" name="annee">
    ISBN <input type="text" name="isbn">
         <input type="submit" name="ajouter" value="AJOUTER FICHE">
         <input type="submit" name="modifier" value="MODIFIER FICHE (sur ISBN)">
</pre></form>
</div>
_END;



}
}