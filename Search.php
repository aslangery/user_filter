<?php
/**
 * Created by PhpStorm.
 * User: Aslangery
 * Date: 02.03.2018
 * Time: 0:03
 */

class Search
{
	protected $tempTable='usersTemp';

	/**
	 * Search constructor.
	 */
	public function __construct()
	{
		$dsn = 'mysql:dbname=USERSDB;host=127.0.0.1';
		$user = 'root';
		$password = 'root';

		try {
			$this->pdo = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			return 'Подключение не удалось: ' . $e->getMessage();
		}
	}

	/**
	 * @param array  $columns
	 * @param Filter $filter
	 *
	 * @return array|null
	 */
	public function search($columns=array(), Filter $filter)
	{
		if ($this->prepareTable()){
			$cols=implode(', ',$columns);
			$query='SELECT '.$cols.' FROM '.$this->tempTable.' WHERE '.$filter->getFilter();
			var_dump($query);
			$statement=$this->pdo->prepare($query);
			if($statement->execute())
			{
				return $result=$statement->fetchAll(PDO::FETCH_CLASS);
			}
		}
		return null;
	}

	/**
	 * @return bool
	 */
	protected function prepareTable()
	{
		$query='CREATE TEMPORARY TABLE '.$this->tempTable.'
	(SELECT u.id, u.email, u.role, u.reg_date, u.last_visit,
       ua.value as country,
       ub.value as firstname,
       uc.value as state
     FROM users As u
       left Join users_about as ua on ua.user=u.id and ua.item=\'country\'
       left Join users_about as ub on ub.user=u.id and ub.item=\'firstname\'
       left Join users_about as uc on uc.user=u.id and uc.item=\'state\')';
		$statement=$this->pdo->prepare($query);
		return $statement->execute();
	}
}