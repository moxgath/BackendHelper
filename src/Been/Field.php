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
	public function getLabel() { /**/
		return ucfirst(camel_case($this->name));
	}

	private function getFormBuilder() {
		$app = app();
		return new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->getToken());
	}

	public function render() {
		$formBuilder = $this->getFormBuilder();
		switch ($this->type) {
			case 'select': {
				return $formBuilder->select($this->name, $this->value, $this->selected, $this->options);
				break;
			}
			case 'textarea':
			case 'editor': {
				if($this->type == 'editor') {
					$this->options['class'] = 'summernote';
				}
				return $formBuilder->textarea($this->name, $this->value, $this->options);
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
				return implode(PHP_EOL, $html);
				break;
			}
			case 'select': {
				return $formBuilder->select($this->name, $this->value, $this->selected, $this->options);
				break;
			}
			case 'date': {
				$this->options['data-plugin-datepicker'] = 'data-plugin-datepicker';
				$this->options['data-plugin-options'] = '{\"format\": \"yyyy-mm-dd\"}';
				return $formBuilder->input('text', $this->name, $this->value ?: date('Y-m-d'), $this->options);
				break;
			}
			case 'toggle': {
				$html = '<div class="switch switch-primary">
							<input type="checkbox" name="'.$this->name.'" data-plugin-ios-switch'.($this->value ? ' checked="checked"' : '').'>
						</div>';
				return $html;
				break;
			}
			default: {
				return $formBuilder->input($this->type, $this->name, $this->value, $this->options);
				break;
			}
		}
	}
}