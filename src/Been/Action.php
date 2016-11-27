<?php

namespace Moxga\BackendHelper\Been;

use Collective\Html\FormBuilder;

class Action {
	private $url;
	private $method;
	private $style;
	private $icon;
	private $title;

	public function setUrl($value) {
		$this->url = $value;
	}
	public function setMethod($value) {
		$this->method = $value;
	}
	public function setStyle($value) {
		$this->style = $value;
	}
	public function setIcon($value) {
		$this->icon = $value;
	}
	public function setTitle($value) {
		$this->title = $value;
	}

	public function getUrl() {
		return $this->url;
	}
	public function getMethod() {
		return $this->method;
	}
	public function getStyle() {
		return $this->style;
	}
	public function getIcon() {
		return $this->icon;
	}
	public function getTitle() {
		return $this->title;
	}

	public function render($item) {
		$formBuilder = $this->getFormBuilder();
		$html        = [];
		$url         = $this->replaceUrl($item);

		$html[]      = $formBuilder->open(['method' => $this->method, 'url' => $url, 'style' => 'display: inline']);
		$html[]      = '<button type="submit" class="btn btn-'.$this->style.'" data-toggle="tooltip" title="'.$this->title.'"><i class="'.$this->icon.'"></i></button>';
		$html[]      = $formBuilder->close();
		return implode(PHP_EOL, $html);
	}

	private function replaceUrl($item) {
    	preg_match_all("/\{([a-z]+)\}/", $this->url, $matches);
    	$replaceArray = [];
    	foreach($matches[1] as $match) {
    		$replaceArray[] = $item->$match;
    	}
    	return str_replace($matches[0], $replaceArray, $this->url);
	}
	private function getFormBuilder() {
		$app = app();
		return new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->getToken());
	}
}