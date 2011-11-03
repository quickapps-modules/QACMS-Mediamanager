<?php echo $this->Html->css('/mediamanager/css/elfinder/smoothness/jquery-ui-1.8.13.custom.css'); ?>
<?php echo $this->Html->css('/mediamanager/css/elfinder/elfinder.css'); ?>

<?php echo $this->Html->script('/mediamanager/js/elfinder/jquery-ui-1.8.13.custom.min.js'); ?>
<?php echo $this->Html->script('/mediamanager/js/elfinder/elfinder.min.js'); ?>		
<?php echo $this->Html->script('/mediamanager/js/elfinder/i18n/elfinder.' . Configure::read('Variable.language.code') . '.js'); ?>		
  
<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        $('#finder').elfinder({
            places: '',
            url : '<?php echo $this->Html->url('/admin/mediamanager/connector/connect', true); ?>',
            lang : '<?php echo Configure::read('Variable.language.code'); ?>',
            docked : true
        })			
    });
</script>

<div id="finder">finder</div>