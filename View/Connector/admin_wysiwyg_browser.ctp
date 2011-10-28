<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
    <head>
        <?php echo $this->Html->script('jquery.js'); ?>
        <?php echo $this->Html->css('/mediamanager/css/elfinder/smoothness/jquery-ui-1.8.13.custom.css'); ?>
        <?php echo $this->Html->css('/mediamanager/css/elfinder/elfinder.css'); ?>

        <?php echo $this->Html->script('/mediamanager/js/elfinder/jquery-ui-1.8.13.custom.min.js'); ?>
        <?php echo $this->Html->script('/mediamanager/js/elfinder/elfinder.min.js'); ?>		
        <?php echo $this->Html->script('/mediamanager/js/elfinder/i18n/elfinder.' . Configure::read('Variable.language.code') . '.js'); ?>		

    </head>
    <body>
          
        <script type="text/javascript" charset="utf-8">
            var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
            var langCode = window.location.search.replace(/^.*langCode=([a-z]{2}).*$/, "$1");
    
            $().ready(function() {
                $('#finder').elfinder({
                    places: '',
                    url : '<?php echo $this->Html->url('/admin/mediamanager/connector/connect'); ?>',
                    lang : '<?php echo Configure::read('Variable.language.code'); ?>',
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
                    
                    <?php endswitch; ?>
                })
            });
            

        </script>

        <div id="finder">finder</div>

    </body>
</html>