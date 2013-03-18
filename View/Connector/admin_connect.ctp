<?php
header('Access-Control-Allow-Origin: *');
App::uses('elFinderConnector', 'Mediamanager.Lib');
App::uses('elFinder', 'Mediamanager.Lib');
App::uses('elFinderVolumeDriver', 'Mediamanager.Lib');
App::uses('elFinderVolumeLocalFileSystem', 'Mediamanager.Lib');

/**
 * This method will disable accessing files/folders starting from  '.' (dot)
 *
 * @param string $attr Attribute name (read|write|locked|hidden)
 * @param string $path File path relative to volume root directory started with directory separator
 * @return mixed boolean or null
 **/
function mediamanagerAccess($attr, $path, $data, $volume) {
    if (strpos(basename($path), '.') === 0) {
        return !($attr == 'read' || $attr == 'write');
    } else {
        return null;
    }
}

$opts = array(
    'debug' => (Configure::read('debug') > 0),
	'roots' => array(
		array(
            'alias' => __d('mediamanager', 'Files'),
			'driver' => 'LocalFileSystem',
			'path' => WWW_ROOT . 'files',
			'URL' => QuickApps::strip_language_prefix(Router::url('/files/', true)),
            'accessControl' => 'mediamanagerAccess',
            'tmbCrop' => false,
            'dateFormat' => __d('mediamanager', 'j M Y H:i')
		),
		array(
            'alias' => __d('mediamanager', 'Themes'),
			'driver' => 'LocalFileSystem',
			'path' => ROOT . DS . 'Themes' . DS . 'Themed',
			'URL' => Router::url('/admin/mediamanager/connector/get_file/' . base64_encode(ROOT . DS . 'Themes' . DS . 'Themed') . '/?type=theme&file=', true),
            'accessControl' => 'mediamanagerAccess',
            'tmbCrop' => false,
            'dateFormat' => __d('mediamanager', 'j M Y H:i')
		),
        array(
            'alias' => __d('mediamanager', 'Modules'),
			'driver' => 'LocalFileSystem',
			'path' => ROOT . DS . 'Modules',
			'URL' => Router::url('/admin/mediamanager/connector/get_file/' . base64_encode(ROOT . DS . 'Modules') . '/?type=module&file=', true),
            'accessControl' => 'mediamanagerAccess',
            'tmbCrop' => false,
            'dateFormat' => __d('mediamanager', 'j M Y H:i')
		)
	)
);

$this->Layout->hook('mediamanager_roots_alter', $opts['roots']);

$connector = new elFinderConnector(new elFinder($opts));
$connector->run();