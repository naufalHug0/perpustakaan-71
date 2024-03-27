<?php 
class Controller {
    public static function model($model)
    {
        require_once dirname(__FILE__).'/../models/' . $model . '.php';
        return new $model;
    }
}