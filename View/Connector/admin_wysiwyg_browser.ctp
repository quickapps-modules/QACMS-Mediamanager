<?php
    $this->JqueryUI->theme('Mediamanager.smoothness');
    $this->Layout->css('/mediamanager/css/elfinder.min.css');
    $this->Layout->css('/mediamanager/css/theme.css');
    $this->Layout->script('/mediamanager/js/elfinder.min.js');
    $this->JqueryUI->add('selectable');
    $this->JqueryUI->add('draggable');
    $this->JqueryUI->add('droppable');

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
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="<?php echo $language_code; ?>">
    <head>
        <?php echo $this->Layout->stylesheets(); ?>
        <?php echo $this->Layout->javascripts(); ?>
        <?php echo $this->Layout->header(); ?>
    </head>

    <body>
        <script type="text/javascript" charset="utf-8">
            var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
            var langCode = window.location.search.replace(/^.*langCode=([a-z]{2}).*$/, "$1");

			function mm_checkUrl(url){
				if (url.match(/\/get_file\//i)) {
					var p = url.split('file=')[1];

					if (url.match(/\/webroot\//i)) {
						var appName = p.split('/')[0];
						var wr = p.split('/webroot/')[1];

						if (url.match(/type\=theme/i)) {
							url = QuickApps.settings.base_url + 'theme/' + appName + '/' + wr;
						} else {
							appName = appName.replace(/([A-Z])/g, function($1) {
								return '_' + $1.toLowerCase();
							}).replace(/^_/i, '').replace(/(_){2,}/g, '_');

							url = QuickApps.settings.base_url + appName + '/' + wr;
						}
					}
				}
				
				return url;
			}

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
                        getFileCallback : function(url) {
                            window.opener.CKEDITOR.tools.callFunction(funcNum, mm_checkUrl(url));
                            window.close();
                        }
                        <?php break; ?>
                        <?php case 'tinymce': ?>
                            getFileCallback : function(url) {
                                window.tinymceFileWin.document.forms[0].elements[window.tinymceFileField].value = mm_checkUrl(url);
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