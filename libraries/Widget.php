<?php
/**
* Orange Framework Extension
*
* This content is released under the MIT License (MIT)
*
* @package	CodeIgniter / Orange
* @author	Don Myers
* @license	http://opensource.org/licenses/MIT	MIT License
* @link	https://github.com/dmyers2004
*
*/
class Widget {
	/* per page request token */
	public $token_set = false;

	/* what html element selector are we looking for? */
	public $selector;

	/* where is the Ajax Handler  */
	public $handler_url;

	public function __construct() {
		/* set these up from the configs or just use the defaults */
		$this->selector = setting('widget','selector','[data-widget]');
		$this->handler_url = setting('widget','handler_url','/widget_handler');
		
		/* use token */
		$use_token = setting('widget','use_token',false);

		/* if it's a ajax request then the token is already set */
		if (ci()->input->is_ajax_request()) {
			if ($use_token) {
				$this->token_set = ci()->session->userdata('widget_token');
			}
		} else {
			if ($use_token) {
				/* This is the html page request so setup page token */
				$this->token_set = sha1(uniqid());

				/* save it for each ajax request */
				ci()->session->set_userdata('widget_token',$this->token_set);

				/* add it to a page variable incase we want to add it manually without */
				ci()->page->data('widget_token',$this->token_set);
			}

			/* add the dynamic ajax requester */
			ci()->page->domready(str_replace(['%%selector%%','%%handler%%'],[$this->selector,$this->handler_url],file_get_contents(__DIR__.'/domready.min.js')));
		}
	}

	/* used by the controller "handler" */
	public function request($options) {
		$reply = '{{Token Error}}';

		/* is the token correct? */
		if ($options['wkey'] === $this->token_set || $this->token_set === false) {
			/* run the widget */
			$reply = $this->show($options);
		}

		return $reply;
	}

	/* Runs a callback method and returns the contents to the view */
	public function show($options) {
		$cache_name = 'widget_'.md5(json_encode($options));

		if (!$output = ci()->cache->get($cache_name)) {
			/* add a validation rule just for widgets */
			ci()->validate->attach('widget_command',function($validate,$field,$options) {
				/* make sure we only have 2 parts ie 1 colon */
				if (count(explode(':',$field)) !== 2) {
					return false;
				}

				return (bool)(preg_match("#^[0-9A-Za-z\/:_]+$#", $field));
			});
			
			/* validate the library and class */
			if (!ci()->input->is_valid('required|max_length[64]|widget_command',$options['widget'],false)) {
				show_404(); /* validation failed */
			}

			/* verification passed - split off the library and method */
			list($class, $method) = explode(':',$options['widget'],2);

			/* add widget to the begining of the class name */
			$classname = 'Widget_'.basename($class);

			/*
			Let PHP try to autoload it through any available autoloaders
			(including Composer and user's custom autoloaders). If we
			don't find it, then assume it's a CI library that we can reach.
			*/
			if (class_exists($classname)) {
				$obj = new $classname();
			} else {
				$classfile = trim(dirname($class).'/'.$classname,'/');

				ci()->load->library($classfile);

				$classname = strtolower($classname);

				$obj =& ci()->$classname;
			}

			if (!method_exists($obj, $method)) {
				log_error('debug','can\'t find method '.$class.'>'.$method);

				show_404(); /* failed */
			}

			/* Call the class with our parameters */
			$output = $obj->{$method}($options);

			/* cache length - use parameter cache="0" for no cache */
			$cache_ttl = (isset($options['cache'])) ? (int)$options['cache'] : setting('config','cache_ttl');

			/* cache it */
			if ($cache_ttl > 0) {
				ci()->cache->save($cache_name, $output, $cache_ttl);
			}
		}

		return $output;
	}

	/* <span data-widget="blog/posts:no_cache_entry" data-limit="5" data-sort="publish_on" data-dir="desc"></span> */
	public function widget($element,$call,$options=[]) {
		$options_text = '<'.$element.' ';
		
		$options['widget'] = $call;

		if ($this->token_set) {
			$options['wkey'] = $this->token_set;
		}

		foreach ($options as $k=>$v) {
			$options_text .= 'data-'.$k.'="'.$v.'" ';
		}

		return $options_text.'">';
	}

	/* merge incoming data with the defaults - only allow key in the default - strip the rest */
	public function merge($data=[],$defaults=[]) {
		return array_diff_key((array)$defaults,(array)$data) + array_intersect_key((array)$data,(array)$defaults);
	}

	public static function build($element,$call,$options=[]) {
		echo ci()->widget->widget($element,$call,$options);
	}
	
	public static function key() {
		echo (!ci()->widget->token_set) ? '' : 'data-wkey="'.ci()->widget->token_set.'"';
	}

} /* end class */