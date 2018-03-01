<?php
/**
 * Created by PhpStorm.
 * User: Aslangery
 * Date: 23.02.2018
 * Time: 23:28
 */

class Filter
{
	protected $filter='';

	protected $pdo;

	/**
	 * @return string
	 */
	public function getFilter(): string
	{
		return $this->filter;
	}

	/**
	 * @param string $key
	 * @param string $value
	 * @param string $bind
	 *
	 * @return $this
	 */
	public function equal($key='', $value='', $bind='AND')
	{
		if ($this->filter=='')
		{
			$this->filter=$key."= '".$value."'";
		}
		else
		{
			$this->filter="((".$this->filter.") ".$bind." ".$key."='".$value."')";
		}
		return $this;
	}

	/**
	 * @param string $key
	 * @param string $value
	 * @param string $bind
	 *
	 * @return $this
	 */
	public function notEqual($key='', $value='', $bind='AND')
	{
		if ($this->filter=='')
		{
			$this->filter="(".$key."<> '".$value."')";
		}
		else
		{
			$this->filter="(".$this->filter." ".$bind." (".$key."<>'".$value."'))";
		}
		return $this;
	}

	/**
	 * @param Filter $filter
	 * @param string $bind
	 *
	 * @return $this
	 */
	public function joinFilter(Filter $filter, $bind='AND')
	{
		$this->filter.=' '.$bind.' '.$filter->getFilter();
		return $this;
	}
}