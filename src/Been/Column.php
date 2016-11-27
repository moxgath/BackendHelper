<?php

namespace Moxga\BackendHelper\Been;

class Column {
	private $key  = null;
	private $name = null;

	public function setKey($value) {
		$this->key = $value;
	}
	public function getKey() {
		return $this->key;
	}

	public function setName($value) {
		$this->name = $value;
	}
	public function getName() {
		return $this->name;
	}

	public function getColumnName() {
		return $this->name ?: ucfirst(str_replace('.', ' ', $this->key));
	}

	public function getColumnValue($data) {
		if(!str_contains($this->key, '.')) {
			return $data->{$this->key};
		}
		else {
			foreach(explode('.', $this->key) as $index => $key) {
				if($index === 0) {
					$value = @$data->$key;
				}
				else {
					$value = @$value->$key;
				}
			}
			return $value !== null ? $value : "-";
		}
	}
}