<?php
    $this->Layout->css('/mediamanager/css/elfinder/smoothness/jquery-ui-1.8.13.custom.css');
    $this->Layout->css('/mediamanager/css/elfinder/elfinder.css');
    $this->Layout->script('/mediamanager/js/elfinder/jquery-ui-1.8.13.custom.min.js');
    $this->Layout->script('/mediamanager/js/elfinder/elfinder.min.js');

    App::import('I18n', 'Locale');

    $L10n = new L10n;
    $langs = $L10n->map();

    if (isset($langs[Configure::read('Variable.language.code')])) {
        $language_code = $langs[Configure::read('Variable.language.code')];
    } else {
        $language_code = 'en';
    }

    if (file_exists(
            CakePlugin::path('Mediamanager') .
            'webroot' . DS . 'js' . DS . 'elfinder' . DS . 'i18n' . DS .
            'elfinder.' . $language_code . '.js'
        )
    ) {
        echo $this->Html->script('/mediamanager/js/elfinder/i18n/elfinder.' . $language_code . '.js');
    }
?>

<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        $("#ModuleAdminSettingsForm").submit(function(e){
          return false;
        });

        $('#ModuleAdminSettingsForm div.submit').hide();
        $('#finder').elfinder({
            places: '',
            url : '<?php echo $this->Html->url('/admin/mediamanager/connector/connect', true); ?>',
            lang : '<?php echo $language_code; ?>',
            docked : true
        })
    });
</script>

<div id="finder">finder</div>