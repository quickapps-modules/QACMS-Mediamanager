<?php
class FilterController extends MediamanagerAppController {
	var $name = 'Filter';
	var $uses = array();

    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    function get(){
        if( !isset($this->request->query['file'])) {
            exit;
        }

        $this->request->query['file'] = 
            preg_replace(
                array(
                    '/\/{2,}/i',    // 2 or more slash -> /
                    '#/$#',         // remove the trailing slash
                    '/^\//'         // remove start slash
                ), 
                array(
                    '/', 
                    '',
                    ''
                ),
                $this->request->query['file']
            );

        $path = 'files/' . $this->request->query['file'];
        $file = basename($path);
        $ext = $this->__findexts($file);
		$this->viewClass = 'Media';
		$params = array(
			'id' => $file,
			'name' => preg_replace("/\.{$ext}/i", '', $file),
			'download' => false,
			'extension' => $ext,
			'path' => str_replace($file, '', realpath($path))
		);

        //TODO: Validate file access
        /*
            $user = $this->Session('Auth.User');
            $file = $this->FileAccess->find('first', 
                array(
                    'conditions' => array('FileAccess.id' => $this->request->query['file'])
                )
            );
        
        */
        
		$this->set($params);
    }

    function __findexts($filename) { 
        $filename = strtolower($filename) ; 
        $exts = split("[/\\.]", $filename) ; 
        $n = count($exts)-1; 
        $exts = $exts[$n]; 

        return $exts; 
    }

    function admin_index(){
        $this->redirect('/admin/filemanager/explorer');
    }
}