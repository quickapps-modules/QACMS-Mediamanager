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
    
    public function form_textarea_alter(&$data) {
        if (($settings = Configure::read('Modules.wysiwyg.settings')) && isset($data['options']['class']) && strpos($data['options']['class'], 'full') !== false) {
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

            switch ($settings['editor']) {
                case 'ckeditor':
                $after .= '
<script>
    CKEDITOR.replace("' . $field_id . '", {
       filebrowserBrowseUrl : "' . Router::url('/admin/mediamanager/connector/wysiwyg_browser/ckeditor/', true) . '"
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