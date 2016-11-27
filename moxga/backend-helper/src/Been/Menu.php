<?php

namespace Moxga\BackendHelper\Been;

class Menu {
	private $name;
	private $icon;
	private $url     = null;
	private $subMenu = [];

	public function setName($value)
    {
        $this->name = $value;
    }
	public function setIcon($value)
    {
        $this->icon = $value;
    }
	public function setUrl($value)
    {
        $this->url = $value;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getIcon()
    {
        return $this->icon;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function getSubMenu()
    {
        return $this->subMenu;
    }

    public function addSubMenu($name, $url = null, $icon = 'fa fa-file-o') {
		$menu = new Menu;
		$menu->setName($name);
		$menu->setIcon($icon);
		$menu->setUrl($url);

		array_push($this->subMenu, $menu);
		return $menu;
	}
}