<?php
Configure::write('debug', 0);
App::uses('elFinderConnector', 'Mediamanager.Lib');
App::uses('elFinder', 'Mediamanager.Lib');
App::uses('elFinderVolumeDriver', 'Mediamanager.Lib');
App::uses('elFinderVolumeLocalFileSystem', 'Mediamanager.Lib');

$opts = array(
	'roots' => array(
		array(
            'alias' => __d('mediamanager', 'Files'),
			'driver' => 'LocalFileSystem',
			'path' => WWW_ROOT . 'files',
			'URL' => QuickApps::strip_language_prefix(Router::url('/files/', true)),
			'accessControl' => false
		),
		array(
            'alias' => __d('mediamanager', 'Themes'),
			'driver' => 'LocalFileSystem',
			'path' => ROOT . DS . 'Themes' . DS . 'Themed',
			'URL' => Router::url('/admin/mediamanager/connector/get_file/' . base64_encode(ROOT . DS . 'Themes' . DS . 'Themed') . '/?file=', true),
			'accessControl' => false
		),
        array(
            'alias' => __d('mediamanager', 'Modules'),
			'driver' => 'LocalFileSystem',
			'path' => ROOT . DS . 'Modules',
			'URL' => Router::url('/admin/mediamanager/connector/get_file/' . base64_encode(ROOT . DS . 'Modules') . '/?file=', true),
			'accessControl' => false
		)
	)
);

$this->Layout->hook('mediamanager_roots_alter', $opts['roots']);

$connector = new elFinderConnector(new elFinder($opts));
$connector->run();