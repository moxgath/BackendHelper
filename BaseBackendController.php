<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Game;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Moxga\BackendHelper\BackendHelper;
use Route;

class BaseBackendController extends Controller
{
    protected $backendHelper;
    protected $model;
    protected $baseRoute;
    protected $filePath;

    public function __construct($title = 'Moxga Backend', $model = null)
    {
        $this->backendHelper = new BackendHelper($title, $model);
        $this->backendHelper->addMenu('Home', action('Backend\HomeController@index'), 'fa fa-dashboard');

        /* */

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
            $this->storeCallback($request, $item);
        }

        return redirect()->route($this->baseRoute.'.index')->with('toastr', ['success' => 'Created !']);
    }

    public function update(Request $request, $id) {
        $item = $this->model::findOrFail($id);
        $rules = $this->model::$rules;

        if(isset($this->model::$editRules)) {
            $rules = array_merge($rules, $this->model::$editRules);
        }

        $this->validate($request, $rules);
        $inputs = $request->except(['_token', '_method']);

        $fileNameList = $this->uploadFiles($request, $item);
        $inputs = array_merge($inputs, $fileNameList);

        $item->update($inputs);
        if(method_exists($this, 'updateCallback')) {
            $this->updateCallback($request, $item);
        }
        return redirect()->route($this->baseRoute.'.edit', $item->id)->with('toastr', ['success' => 'Updated !']);
    }

    public function destroy($id) {
        $item = $this->model::findOrFail($id);
        $item->delete();
        return redirect()->route($this->baseRoute.'.index')->with('toastr', ['success' => 'Removed !']);
    }

    protected function uploadFiles(Request $request, $item) {
        $returnValue = [];
        foreach($request->except(['_token', '_method']) as $name => $input) {
            if($request->hasFile($name) && $request->file($name) instanceof UploadedFile) {
                $fileName = $this->uploadFile($request->file($name), $this->filePath);
                if($fileName) {
                    if($item->$name && $item->$name != $fileName && Storage::disk('public')->exists($this->filePath.'/'.$item->$name)) {
                        Storage::disk('public')->delete($this->filePath.'/'.$item->$name);
                    }
                    $returnValue[$name] = $fileName;
                }
            }
        }
        return $returnValue;
    }

    protected function uploadFile($file, $path, $disk = 'public') {
        if($file) {
            $path = $file->store($path, $disk);
            if($path) {
                $exploded = explode('/', $path);
                $fileName = end($exploded);
                return $fileName;
            }
        }
        return null;
    }
}