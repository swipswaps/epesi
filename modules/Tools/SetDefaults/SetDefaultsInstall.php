<?php
/**
 * @author Janusz Tylek <jtylek@telaxus.com>
 * @copyright Copyright &copy; 2008, Telaxus LLC
 * @version 0.1
 * @license SPL
 * @package epesi-tools
 * @subpackage setdefaults
 */
defined("_VALID_ACCESS") || die('Direct access forbidden');

class Tools_SetDefaultsInstall extends ModuleInstall {

	public function install() {
		
		// Setting default AB icons and launchpad
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', '465e51c2b6eba36161f0115442e7406c_d', 's:1:"1";'));
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', '465e51c2b6eba36161f0115442e7406c_l', 's:1:"1";'));
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', '4fe4700ae455ac705d9d5efa1292298b_d', 's:1:"1";'));
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', '4fe4700ae455ac705d9d5efa1292298b_l', 's:1:"1";'));
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', '5ee46bef4c047bd8816ac3810270cc73_d', 's:1:"1";'));
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', '5ee46bef4c047bd8816ac3810270cc73_l', 's:1:"1";'));
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', '7b3558122283d2a14051c96a7da1fb1b_d', 's:1:"1";'));
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', '7b3558122283d2a14051c96a7da1fb1b_l', 's:1:"1";'));
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', 'b34db58caa3e6a8b933deca655640047_d', 's:1:"1";'));
		DB::Execute('INSERT INTO base_user_settings_admin_defaults (module, variable, value) VALUES (%s, %s, %s)', array('Base_Menu_QuickAccess', 'b34db58caa3e6a8b933deca655640047_l', 's:1:"1";'));

		// default applets
		DB::Execute('INSERT INTO base_dashboard_default_applets (id, module_name, col, pos, tab) VALUES (%d, %s, %d, %d, %d)', array(1,'Applets_Clock',0,0,1));
		DB::Execute('INSERT INTO base_dashboard_default_applets (id, module_name, col, pos, tab) VALUES (%d, %s, %d, %d, %d)', array(2,'Applets_RssFeed',2,0,1));
		DB::Execute('INSERT INTO base_dashboard_default_applets (id, module_name, col, pos, tab) VALUES (%d, %s, %d, %d, %d)', array(3,'CRM_Tasks',1,0,1));
		DB::Execute('INSERT INTO base_dashboard_default_applets (id, module_name, col, pos, tab) VALUES (%d, %s, %d, %d, %d)', array(4,'CRM_PhoneCall',1,1,1));
		DB::Execute('INSERT INTO base_dashboard_default_applets (id, module_name, col, pos, tab) VALUES (%d, %s, %d, %d, %d)', array(5,'CRM_Calendar',1,2,1));

		return true;
	}
	
	public function uninstall() {
		return true;
	}
	
	public function version() {
		return array("1.0");
	}
	
	public function requires($v) {
		return array(
			array('name'=>'Base/Theme','version'=>0),
			array('name'=>'Utils/Wizard','version'=>0),
			array('name'=>'Base/Lang','version'=>0),
			array('name'=>'CRM/Calendar','version'=>0),
			array('name'=>'CRM/Contacts','version'=>0),
			array('name'=>'CRM/PhoneCall','version'=>0),
			array('name'=>'CRM/Tasks','version'=>0)
			);
	}
}

?>