<?php
class ConnectorController extends MediamanagerAppController {
	public $name = 'Connector';
	public $uses = array();

    public function admin_connect() {
    }

    public function admin_get_file($path) {
        $this->viewClass = 'Media';
        $path = base64_decode($path) . DS;
        $file = str_replace('/', DS, $this->request->query['file']);
        $fullPath = str_replace(DS . DS, DS, $path . $file);
        $params = array(
            'id'        => basename($fullPath),
            'name'      => preg_replace('/\.' . end(explode('.', basename($fullPath))) . '$/', '', basename($fullPath)),
            'download'  => false,
            'extension' => end(explode('.', basename($fullPath))),
            'path'      => dirname($fullPath) . DS
        );

        $this->set($params);
    }

    public function admin_wysiwyg_browser($editor = 'ckeditor') {
        $this->layout = false;
        $this->autoRender = true;

        $this->set('editor', $editor);
    }
}