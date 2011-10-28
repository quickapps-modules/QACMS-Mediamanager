<?php
class InstallComponent extends Component {
	var $Controller = null;
    
    function beforeInstall($Installer) {
        return true;
    }
    
    function afterInstall($Installer) {
        return true;
    }
    
    function beforeUninstall($Installer) {
        return true;
    }
    
    function afterUninstall($Installer) {
        return true;
    }
}