<?php

namespace Moxga\BackendHelper\Been;

use Collective\Html\FormBuilder;

class Field {
	private $type;
	private $name;
	private $value    = null;
	private $selected = null;
	private $options  = [];

	public function setType($value) {
		$this->type = $value;
	}
	public function setName($value) {
		$this->name = $value;
	}
	public function setValue($value) {
		$this->value = $value;
	}
	public function setSelected($value) {
		$this->selected = $value;
	}
	public function setOptions($value) {
		$this->options = $value;
	}

	public function getType() {
		return $this->type;
	}
	public function getName() {
		return $this->name;
	}
	public function getValue() {
		return $this->value;
	}
	public function getSelected() {
		return $this->selected;
	}
	public function getOptions() {
		return $this->options;
	}
	public function getLabel() { /* */
		return ucfirst(camel_case($this->name));
	}

	private function getFormBuilder() {
		$app = app();
		return new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->getToken());
	}

	public function render() {
		$formBuilder = $this->getFormBuilder();
		$html = null;
		switch ($this->type) {
			case 'select': {
				$html = $formBuilder->select($this->name, $this->value, $this->selected, $this->options);
				break;
			}
			case 'textarea':
			case 'editor': {
				if($this->type == 'editor') {
					$this->options = array_merge($this->options, ['class' => 'summernote']);
				}
				$html = $formBuilder->textarea($this->name, $this->value, $this->options);
				break;
			}
			case 'multiselect': {
				$html = [];
				$html[] = '<select name="'.$this->name.'[]" class="form-control" multiple="multiple" data-plugin-multiselect data-plugin-options=\'{ "enableCaseInsensitiveFiltering": true }\'>';
				foreach($this->value as $key => $val) {
					if(in_array($key, $this->selected)) {
						$html[] = '<option value="'.$key.'" selected>'.$val.'</option>';
					} else {
						$html[] = '<option value="'.$key.'">'.$val.'</option>';
					}
				}
				$html[] = '</select>';
				$html = implode(PHP_EOL, $html);
				break;
			}
			case 'select': {
				$options = array_merge($this->options, ['class' => 'form-control populate', 'data-plugin-selectTwo']);
				$html = $formBuilder->select($this->name, $this->value, $this->selected, $options);
				break;
			}
			case 'date': {
				$value = date('Y-m-d', strtotime($this->value)) ?: date('Y-m-d');
				$html = '<input type="text" name="'.$this->name.'" data-plugin-datepicker class="form-control" value="'.$value.'" data-plugin-options=\'{ "format": "yyyy-mm-dd" }\'>';
				break;
			}
			case 'time': {
				$value = date('H:i:s', strtotime($this->value)) ?: date('H:i:s');
				$html = '<input type="text" name="'.$this->name.'" data-plugin-timepicker class="form-control" value="'.$value.'" data-plugin-options=\'{ "showMeridian": false }\'>';
				break;
			}
			case 'datetime': {
				$value = date('Y-m-d H:i:s', strtotime($this->value)) ?: date('H:i:s');
				$html = '<input type="text" name="'.$this->name.'" data-plugin-datetimerpicker class="form-control" value="'.$value.'">';
				break;
			}
			case 'toggle': {
				$html = '<div class="switch switch-primary">
							<input type="checkbox" value="1" name="'.$this->name.'" data-plugin-ios-switch'.($this->value ? ' checked="checked"' : '').'>
						</div>';
				break;
			}
			default: {
				$html = $formBuilder->input($this->type, $this->name, $this->value, $this->options);
				break;
			}
		}
		return htmlspecialchars_decode($html);
	}
}