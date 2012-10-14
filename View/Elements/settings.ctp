<?php
    $this->jQueryUI->theme('Mediamanager.smoothness');
    $this->Layout->css('/mediamanager/css/elfinder.min.css');
    $this->Layout->css('/mediamanager/css/theme.css');
    $this->Layout->script('/mediamanager/js/jquery-ui-1.8.13.custom.min.js');
    $this->Layout->script('/mediamanager/js/elfinder.min.js');
    $this->jQueryUI->add('selectable');
    $this->jQueryUI->add('draggable');
    $this->jQueryUI->add('droppable');

    App::import('I18n', 'Locale');

    $L10n = new L10n;
    $langs = $L10n->map();

    if (isset($langs[Configure::read('Variable.language.code')])) {
        $language_code = $langs[Configure::read('Variable.language.code')];
    } else {
        $language_code = 'en';
    }

    $i18n = CakePlugin::path('Mediamanager') . 'webroot' . DS . 'js' . DS . 'i18n' . DS . "elfinder.{$language_code}.js";

    if (file_exists($i18n)) {
        $this->Layout->script('/mediamanager/js/i18n/elfinder.' . $language_code . '.js');
    }
?>

<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        $("#ModuleAdminSettingsForm").submit(function(e){
          return false;
        });

        $('#ModuleAdminSettingsForm div.submit').hide();
        $('#finder').elfinder({
            url : '<?php echo Router::url('/admin/mediamanager/connector/connect', true); ?>',
            lang : '<?php echo $language_code; ?>',
            dateFormat: '<?php echo __d('mediamanager', 'M d, Y h:i A'); ?>',
            fancyDateFormat: '<?php echo __d('mediamanager', '$1 H:m:i'); ?>',
            cookie : {
                expires : 30,
                domain  : '',
                path    : '/',
                secure  : false
            },
            debug: <?php echo Configure::read('debug') > 0 ? 'true' : 'false'; ?>
        })
    });
</script>

<div id="finder">finder</div>