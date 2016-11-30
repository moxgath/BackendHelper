<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Game;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Moxga\BackendHelper\BackendHelper;

class BaseBackendController extends Controller 
{
	protected $backendHelper;
	protected $model;
	protected $baseRoute;
	protected $filePath;

	public function __construct($title = 'Shosha Backend', $model = null)
	{
		$this->backendHelper = new BackendHelper($title, $model);
		$this->backendHelper->addMenu('Home', action('Backend\HomeController@index'), 'fa fa-dashboard');

		$newsMenu = $this->backendHelper->addMenu('News', "#", 'fa fa-newspaper-o');
		$newsMenu->addSubMenu('Topic', action('Backend\NewsController@index'), 'fa fa-list');
		$newsMenu->addSubMenu('Comment', action('Backend\NewsCommentController@index'), 'fa fa-comments');

		$this->model     = $this->backendHelper->getModel();
		$this->baseRoute = $this->backendHelper->getBaseRoute();

		$this->filePath  = '/uploads/'.class_basename($this->model);
	}

	public function index() {
    	return $this->backendHelper->renderIndex();
    }

	public function create() {
		if(!$this->backendHelper->hasAddBtn()) {
			return abort(404);
		}
		return $this->backendHelper->renderCreate();
	}

	public function edit($id) {
		if(!$this->backendHelper->hasEditBtn()) {
			return abort(404);
		}
		$item = $this->model::findOrFail($id);
		return $this->backendHelper->renderEdit($item);
	}

	public function store(Request $request) {
		$this->validate($request, $this->model::$rules);
		$inputs = $request->except(['_token', '_method']);

		$inputs['created_at'] = new DateTime;
		$inputs['updated_at'] = new DateTime;
		$item = $this->model::create($inputs);

		$fileNameList = $this->uploadFiles($request, $item);
		$item->update($fileNameList);

		if(method_exists($this, 'storeCallback')) {
			$this->storeCallback($request);
		}

		return redirect()->route($this->baseRoute.'.edit', $item->id)->with('toastr', ['success' => 'Created !']);;
	}

	public function update(Request $request, $id) {
		$item = $this->model::findOrFail($id);

		$rules = array_merge($this->model::$rules, $this->model::$editRules);
		$this->validate($request, $rules);
		$inputs = $request->except(['_token', '_method']);

		$fileNameList = $this->uploadFiles($request, $item);
		$inputs = array_merge($inputs, $fileNameList);

		$item->update($inputs);

		if(method_exists($this, 'updateCallback')) {
			$this->updateCallback($request, $id);
		}
		return redirect()->route($this->baseRoute.'.edit', $item->id)->with('toastr', ['success' => 'Updated !']);;
	}

	public function destroy($id) {
		$item = $this->model::findOrFail($id);
		$item->delete();
		return redirect()->route($this->baseRoute.'.index')->with('toastr', ['success' => 'Removed !']);;
	}

	protected function uploadFiles(Request $request, $item) {
		$returnValue = [];
		foreach($this->backendHelper->getFiles() as $name) {
			$fileName = $this->uploadFile($request->file($name), $this->filePath);
			if($fileName) {
				if($item->$name && Storage::disk('public')->exists($this->filePath.'/'.$item->$name)) {
                	Storage::disk('public')->delete($this->filePath.'/'.$item->$name);
				}
				$returnValue[$name] = $fileName;
			}
		}
		return $returnValue;
	}
}