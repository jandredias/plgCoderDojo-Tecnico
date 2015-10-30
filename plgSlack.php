<?php
// no direct access
defined( '_JEXEC' ) or die;

class plgUserplgSlack extends JPlugin
{
	/**
	 * Load the language file on instantiation. Note this is only available in Joomla 3.1 and higher.
	 * If you want to support 3.0 series you must override the constructor
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Plugin method with the same name as the event will be called automatically.
	 */
	 function onUserAfterLogin(){
	 	$user = JFactory::getUser();
		/*
		 * Plugin code goes here.
		 * You can access database and application objects and parameters via $this->db,
		 * $this->app and $this->params respectively
		 */
		$data = "{$user->name} has loggedin on coderdojo-tecnico.org at ".date('l jS \of F Y h:i:s A')." from {$_SERVER['REMOTE_ADDR']}\n[USERNAME: {$user->username}]\n[EMAIL: {$user->email}]";
		$data_string = 'payload={"text": "'.$data.'"}';
		$opts = array('http' =>
		  array(
		    'method'  => 'POST',
		    'Content-type' => 'application/x-www-form-urlencoded',
		    'content' => $data_string,
		    'payload' => '{"text": "This is a line of text in a channel.\nAdfgdfgnd this is another line of text."}',
		    'timeout' => 60
		  )
		);
		$context  = stream_context_create($opts);
		$result = file_get_contents($this->params->get('url'), false, $context, -1, 40000);


		return true;
	}
}
 ?>
