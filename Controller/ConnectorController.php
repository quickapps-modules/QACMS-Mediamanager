<?php
class ConnectorController extends MediamanagerAppController {
	public $name = 'Connector';
	public $uses = array();

    public function admin_connect(){
    }

    public function admin_wysiwyg_browser($editor = 'ckeditor') {
        $this->layout = false;
        $this->autoRender = true;

        $this->set('editor', $editor);
    }
}