<?php
/**
 * Created by PhpStorm.
 * User: Aslangery
 * Date: 02.03.2018
 * Time: 0:09
 */
include 'Filter.php';
include 'Search.php';

$filter=new Filter();
//((ID = 1000) ИЛИ (Страна != Россия))
$filter->Equal('id',1000)
	->notEqual('country','Россия', 'OR');

$filter2=new Filter();
//((Страна = Россия) И (Состояние пользователя != active))
$filter->Equal('country', 'Россия')
	->notEqual('state', 'active', 'AND');

$filter3=new Filter();
//((((Страна != Россия) ИЛИ (Состояние пользователя = active))
// И (E-Mail = user@domain.com)) ИЛИ (Имя != ""))
$filter3->notEqual('country', 'Россия')
	->equal('state', 'active', 'OR')
	->equal('email', 'user@domain.com', 'AND')
	->notEqual('username', '', 'OR');

$search=new Search();
$cols=['id','email','role','reg_date'];
$result=$search->search($cols, $filter);
var_dump($result);