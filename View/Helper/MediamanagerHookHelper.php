<?php
/**
 * System Hooks Helper
 *
 * PHP version 5
 *
 * @category Helper
 * @package  QuickApps
 * @version  1.0
 * @author   Christopher Castro <y2k2000@gmail.com>
 * @link     http://www.quickapps.es
 */
class MediamanagerHookHelper extends AppHelper {
    private $__Wysiwyg = null;

    public function form_textarea_alter(&$data) {
        if ($this->__Wysiwyg === null) {
            $this->__Wysiwyg = Configure::read('Modules.Wysiwyg'); // may be slow
        }

        if ($this->__Wysiwyg && isset($data['options']['class']) && strpos($data['options']['class'], 'full') !== false) {
            if (isset($data['options']['id'])) {
                $field_id = $data['options']['id'];
            } else {
                $field_id = '';
                $_name = explode('.', $data['fieldName']);

                foreach ($_name as $sub) {
                    $field_id .= Inflector::camelize($sub);
                }
            }

            $after = $this->_View->Html->script('/mediamanager/js/elfinder/elfinder.min.js');

            switch ($this->__Wysiwyg['settings']['editor']) {
                default:
                    case 'ckeditor':
                        $after .= '
                            <script>
                                $(document).ready(function() {
                                    CKEDITOR.replace("' . $field_id . '", {
                                       filebrowserBrowseUrl : "' . Router::url('/admin/mediamanager/connector/wysiwyg_browser/ckeditor/', true) . '"
                                    });
                                });
                            </script>';
                break;
            }

            if (isset($data['options']['before'])) {
                $data['options']['after'] .= $after;
            } else {
                $data['options']['after'] = $after;
            }
        }
    }
}