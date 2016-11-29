<?php

namespace Moxga\BackendHelper;

use Illuminate\Support\Collection;

use Moxga\BackendHelper\Been\Menu;
use Moxga\BackendHelper\Been\Field;
use Moxga\BackendHelper\Been\Action;
use Moxga\BackendHelper\Been\Column;

class BackendHelper
{
	private $title;
	private $model;
	private $menuList     = [];
	private $fieldList    = [];
	private $dataList     = [];
	private $columnList   = [];
	private $files        = [];
	private $actionList   = [];
	private $editItem     = null;
	private $addBtn       = true;
	private $editBtn      = true;
	private $deleteBtn    = true;
	private $addBtnUrl    = null;
	private $editBtnUrl   = null;
	private $deleteBtnUrl = null;

	public function __construct($title = 'Shosha Backend', $model = null)
	{
		if($model) {
			$this->model = new $model;
		}
		$app         = app();
		$this->title = $title;
	}

	public function addMenu($name, $url = null, $icon = 'fa fa-folder') {
		$menu = new Menu;
		$menu->setName($name);
		$menu->setIcon($icon);
		$menu->setUrl($url);

		array_push($this->menuList, $menu);
		return $menu;
	}

	public function addSelect($name, Collection $list, $selected = null, $options = ['class' => 'form-control']) {
		$field = new Field;
		$field->setType('select');
		$field->setName($name);
		$field->setValue($list->toArray());
		$field->setSelected($selected);
		$field->setOptions($options);
		array_push($this->fieldList, $field);
		return $field;
	}

	public function addInput($type, $name, $value = null, $options = ['class' => 'form-control']) {
		if($type == 'file') {
			array_push($this->files, $name);
		}
		$field = new Field;
		$field->setType($type);
		$field->setName($name);
		$field->setValue($value);
		$field->setOptions($options);
		array_push($this->fieldList, $field);
		return $field;
	}

	public function addAction($title, $url, $method, $style, $icon) {
		$action = new Action;
		$action->setTitle($title);
		$action->setUrl($url);
		$action->setMethod($method);
		$action->setStyle($style);
		$action->setIcon($icon);
		array_push($this->actionList, $action);
		return $action;
	}

	public function renderHome(array $parameters = []) {
		return $this->renderCustomView('backendhelper::home.index', $parameters);
	}

	public function renderIndex($dataList = null, array $parameters = []) {
		$this->dataList = $dataList ?: $this->model->get();
		return $this->renderCustomView('backendhelper::index', $parameters);
	}

	public function renderEdit($item, array $parameters = []) {
		$this->editItem = $item;

		foreach($this->fieldList as $field) {
			$value = null;
			if(!str_contains($field->getName(), '.')) {
				$value = $item->{$field->getName()};
			}
			else {
				foreach(explode('.', $field->getName()) as $index => $key) {
					if($index === 0) {
						$value = $data->$key;
					}
					else {
						$value = $value->$key;
					}
				}
				$value = $item->{$field->getName()};
			}
			if($field->getType() == 'select') {
				$field->setSelected($value);
			} else {
				$field->setValue($value);
			}
		}
		return $this->renderCustomView('backendhelper::edit', $parameters);
	}

	public function renderCreate(array $parameters = []) {
		return $this->renderCustomView('backendhelper::create', $parameters);
	}

	private function renderCustomView(string $viewPath, array $parameters = []) {
		$parameters['backendHelper'] = $this;
		return view($viewPath, $parameters);
	}

	public function getFieldList() {
		return $this->fieldList;
	}

	public function getModel() {
		return $this->model;
	}

	public function getEditItem() {
		return $this->editItem;
	}

	public function setPageTitle($value) {
		$this->title = $value;
	}
	public function getPageTitle() {
		return $this->title;
	}

	public function getFiles() {
		return $this->files;
	}
	public function getActionList() {
		return $this->actionList;
	}

	public function getAddBtnUrl() {
		return $this->addBtnUrl;
	}
	public function getEditBtnUrl() {
		return $this->editBtnUrl;
	}
	public function getDeleteBtnUrl() {
		return $this->deleteBtnUrl;
	}

	public function setAddBtn(bool $value) {
		$this->addBtn = $value;
	}
	public function setEditBtn(bool $value) {
		$this->editBtn = $value;
	}
	public function setAddBtnUrl(bool $value) {
		$this->addBtnUrl = $value;
	}
	public function setEditBtnUrl(bool $value) {
		$this->editBtnUrl = $value;
	}
	public function setDeleteBtnUrl(bool $value) {
		$this->deleteBtnUrl = $value;
	}

	public function hasAddBtn() {
		return $this->addBtn;
	}
	public function hasEditBtn() {
		return $this->editBtn;
	}
	public function hasDeleteBtn() {
		return $this->deleteBtn;
	}

	public function addColumn($key, $name = null) {
		$column = new Column;
		$column->setKey($key);
		$column->setName($name);
		array_push($this->columnList, $column);
	}
	public function getColumnList() {
		return $this->columnList;
	}

	public function getDataList() {
		return $this->dataList;
	}

	public function getMenuList() {
		return $this->menuList;
	}

	public function getBaseRoute() {
		$currentRoute  = \Route::currentRouteName();
		$explodedRoute = explode('.', $currentRoute);
		$explodedRoute = array_slice($explodedRoute, 0, -1);
		$baseRoute     = implode('.', $explodedRoute);
		return $baseRoute;
	}
}
