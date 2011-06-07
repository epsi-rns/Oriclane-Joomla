<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file based on of helloworld component
 */
class com_oriclanInstallerScript
{
        /**
         * method to install the component
         *
         * @return void
         */
        function install($parent) 
        {
			// $parent is the class calling this method
			echo '<p>' . JText::_('COM_ORICLAN_INSTALL_TEXT') . '</p>';			
			
			$manifest = $parent->get("manifest");
			$parent = $parent->getParent();
			$source = $parent->getPath("source");
			 
			$installer = new JInstaller();
			// Install plugins
			foreach($manifest->plugins->plugin as $plugin) {
			    $attributes = $plugin->attributes();
			    $plg = $source . DS . $attributes['folder'].DS.$attributes['plugin'];
			    echo '<p>' . JText::_('COM_ORICLAN_SUBINSTALL_INSTALLING_PLUGIN_TEXT') 
					.'<b>'.$attributes['name'].'</b></p>';   
			    $installer->install($plg);
			}
			
			// Install modules
			foreach($manifest->modules->module as $module) {
			    $attributes = $module->attributes();
			    $mod = $source . DS . $attributes['folder'].DS.$attributes['module'];
			    echo '<p>' . JText::_('COM_ORICLAN_SUBINSTALL_INSTALLING_MODULE_TEXT') 
					.'<b>'.$attributes['name'].'</b></p>';  
			    $installer->install($mod);
			}
			
			$db = JFactory::getDbo();
			$tableExtensions = $db->nameQuote("#__extensions");
			$columnElement   = $db->nameQuote("element");
			$columnType      = $db->nameQuote("type");
			$columnEnabled   = $db->nameQuote("enabled");
			
			// Enable plugins
			$db->setQuery(
			    "UPDATE 
			        $tableExtensions
			    SET
			        $columnEnabled=1
			    WHERE
			        $columnElement='oriclan'
			    AND
			        $columnType='plugin'"
			);
			
			$db->query();
			
        }
 
        /**
         * method to uninstall the component
         *
         * @return void
         */
        function uninstall($parent) 
        {
			    // $parent is the class calling this method
			    echo '<p>' . JText::_('COM_ORICLAN_UNINSTALL_TEXT') . '</p>';
        }
 
        /**
         * method to update the component
         *
         * @return void
         */
        function update($parent) 
        {
			    // $parent is the class calling this method
			    echo '<p>' . JText::_('COM_ORICLAN_UPDATE_TEXT') . '</p>';
        }
 
        /**
         * method to run before an install/update/uninstall method
         *
         * @return void
         */
        function preflight($type, $parent) 
        {
			    // $parent is the class calling this method
			    // $type is the type of change (install, update or discover_install)
			    echo '<p>' . JText::_('COM_ORICLAN_PREFLIGHT_' . $type . '_TEXT') . '</p>';
        }
 
        /**
         * method to run after an install/update/uninstall method
         *
         * @return void
         */
        function postflight($type, $parent) 
        {
			    // $parent is the class calling this method
			    // $type is the type of change (install, update or discover_install)
			    echo '<p>' . JText::_('COM_ORICLAN_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
        }
}
