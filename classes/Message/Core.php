<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Message is a class that lets you easily send messages
 * in your application (aka Flash Messages)
 *
 * @package    Message
 * @author     Dave Widmer
 * @see        http://github.com/daveWid/message
 * @see        http://www.davewidmer.net
 * @copyright  2010-2011 © Dave Widmer
 */
class Message_Core
{
	/**
	 * @var  string    The default view if one isn't passed into display/render.
	 */
	public static $default = "message/basic";

	/**
	 * Constants to use for the types of messages that can be set.
	 */
	const ERROR = 'error';
	const NOTICE = 'notice';
	const SUCCESS = 'success';
	const WARN = 'warn';

	/**
	 * @var  mixed    The message to display.
	 */
	public $message;

	/**
	 * @var  string   The type of message.
	 */
	public $type;

	/**
	 * Creates a new Message instance.
	 *
	 * @param   string   Type of message
	 * @param   mixed    Message to display, either string or array
	 */
	public function __construct($type, $message)
	{
		$this->type = $type;
		$this->message = $message;
	}

	/**
	 * Clears the message from the session.
	 */
	public static function clear()
	{
		Session::instance()->delete('flash_messages');
	}

	/**
	 * Displays the message.
	 *
	 * @param    string    Name of the view
	 * @return   string    Message to string
	 */
	public static function display($view = null)
	{
		echo self::render($view);
	}

	/**
	 * The same as display - used to mold to Kohana standards.
	 *
	 * @param    string    Name of the view
	 * @return   string    HTML for message
	 */
	public static function render($view = null)
	{
		$html = "";
		$msgs = self::get();

		if($msgs)
		{
			if ($view === null)
			{
				$view = self::$default;
			}

			self::clear();
			$html = View::factory($view)->set('messages', $msgs)->render();
		}

		return $html;
	}

	/**
	 * Gets the current message.
	 *
	 * @return   mixed    The message or FALSE
	 */
	public static function get()
	{
		return Session::instance()->get('flash_messages', FALSE);
	}

	/**
	 * Sets a message.
	 *
	 * @param   string   Type of message
	 * @param   mixed    Array/String for the message
	 */
	public static function add($type, $message)
	{
		$msgs = Session::instance()->get('flash_messages', array());
		$msgs[$type][] = new Message($type, $message);
		Session::instance()->set('flash_messages', $msgs);
	}

	/**
	 * Sets an error message.
	 *
	 * @param    mixed    String/Array for the message(s)
	 */
	public static function error($message)
	{
		self::add(Message::ERROR, $message);
	}

	/**
	 * Sets a notice.
	 *
	 * @param    mixed    String/Array for the message(s)
	 */
	public static function notice($message)
	{
		self::add(Message::NOTICE, $message);
	}

	/**
	 * Sets a success message.
	 *
	 * @param    mixed    String/Array for the message(s)
	 */
	public static function success($message)
	{
		self::add(Message::SUCCESS, $message);
	}

	/**
	 * Sets a warning message.
	 *
	 * @param    mixed    String/Array for the message(s)
	 */
	public static function warn($message)
	{
		self::add(Message::WARN, $message);
	}

}
