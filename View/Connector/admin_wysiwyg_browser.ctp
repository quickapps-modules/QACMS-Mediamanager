<?php
    $this->JqueryUI->theme('Mediamanager.smoothness');
    $this->Layout->css('/mediamanager/css/elfinder.min.css');
    $this->Layout->css('/mediamanager/css/theme.css');
    $this->Layout->script('/mediamanager/js/jquery-ui-1.8.13.custom.min.js');
    $this->Layout->script('/mediamanager/js/elfinder.min.js');
    $this->JqueryUI->add('selectable');
    $this->JqueryUI->add('draggable');
    $this->JqueryUI->add('droppable');

    Configure::write('debug', 2);
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
        <?php echo $this->Layout->stylesheets(); ?>
        <?php echo $this->Layout->javascripts(); ?>
        <?php echo $this->Layout->header(); ?>
    </head>

    <body>
        <script type="text/javascript" charset="utf-8">
            var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
            var langCode = window.location.search.replace(/^.*langCode=([a-z]{2}).*$/, "$1");

            $().ready(function() {
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
                    <?php
                        switch ($editor):
                            case 'ckeditor':
                                default:
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