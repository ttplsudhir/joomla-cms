<?php
/**
 * @version		$Id: captcha.php
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldCaptcha extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Captcha';

	/**
	 * Method to attach a JForm object to the field.
	 *
	 * @param   object  &$element  The JXmlElement object representing the <field /> tag for the form field object.
	 * @param   mixed   $value     The form field value to validate.
	 * @param   string  $group     The field name group control value. This acts as as an array container for the field.
	 *                             For example if the field has name="foo" and the group value is set to "bar" then the
	 *                             full field name would end up being "bar[foo]".
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.5
	 */
	public function setup(&$element, $value, $group = null)
	{
		$result = parent::setup($element, $value, $group);

		// Force field to be required. There's no reason to have a captcha if it is not required.
		// Obs: Don't put required="required" in the xml file, you just need to have validate="captcha"
		$this->required = true;
		$class = $this->element['class'];
		if (strpos($class, 'required') === false)
		{
			$this->element['class'] = $class . ' required';
		}

		return $result;
	}

	/**
	 * Method to get the field input.
	 *
	 * @return	string		The field input.
	 */
	protected function getInput()
	{
		$class = $this->element['class'] ? (string) $this->element['class'] : '';
		$plugin = $this->element['plugin'] ? (string) $this->element['plugin'] : '';
		$namespace = $this->element['namespace'] ? (string) $this->element['namespace'] : $this->form->getName();

		if ($plugin === 0 || $plugin === '0'){// Use 0 for none
			return '';
		}
		else{
			if (($captcha = JFactory::getCaptcha($plugin, array('namespace' => $namespace))) == null){
				return '';
			}
		}

		return $captcha->display($this->name, $this->id, $class);
	}
}