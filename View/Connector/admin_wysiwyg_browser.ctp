<?php
    Configure::write('debug', 0);
    App::import('I18n', 'Locale');

    $L10n = new L10n;
    $langs = $L10n->map();

    if (isset($langs[Configure::read('Variable.language.code')])) {
        $language_code = $langs[Configure::read('Variable.language.code')];
    } else {
        $language_code = 'en';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <?php echo $this->Html->script('/system/js/jquery.js'); ?>
        <?php echo $this->Html->css('/mediamanager/css/elfinder/smoothness/jquery-ui-1.8.13.custom.css'); ?>
        <?php echo $this->Html->css('/mediamanager/css/elfinder/elfinder.css'); ?>

        <?php echo $this->Html->script('/mediamanager/js/elfinder/jquery-ui-1.8.13.custom.min.js'); ?>
        <?php echo $this->Html->script('/mediamanager/js/elfinder/elfinder.min.js'); ?>
        <?php echo $this->Html->script('/mediamanager/js/elfinder/i18n/elfinder.' . $language_code . '.js'); ?>
    </head>

    <body>
        <script type="text/javascript" charset="utf-8">
            var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
            var langCode = window.location.search.replace(/^.*langCode=([a-z]{2}).*$/, "$1");

            $().ready(function() {
                $('#finder').elfinder({
                    places: '',
                    url : '<?php echo $this->Html->url('/admin/mediamanager/connector/connect'); ?>',
                    lang : '<?php echo $language_code; ?>',
                    docked : true,
                    <?php
                        switch ($editor):
                            case 'ckeditor': default:
                    ?>
                        editorCallback : function(url) {
                            window.opener.CKEDITOR.tools.callFunction(funcNum, url);
                            window.close();
                        }
                    <?php break; ?>

                    <?php case 'tinymce': ?>
                        editorCallback : function(url) {
                            window.tinymceFileWin.document.forms[0].elements[window.tinymceFileField].value = url;
                            window.tinymceFileWin.focus();
                            window.close();
                        }
                    <?php break; ?>

                    <?php endswitch; ?>
                })
            });
        </script>

        <div id="finder">finder</div>
    </body>
</html>