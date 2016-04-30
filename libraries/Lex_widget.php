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
class lex_widget extends lex_plugin {
	/*
	this provides a wrapper around widgets to call them using LEX in the view
	this makes it easier for the designers to call widgets when using the lex templating syntax
	
	{{ lex.widget widget="examplex:position" format="magic" }}Designer{{ /lex.widget }}
	
	- or - 
	
	{{ lex.widget widget="examplex:position" format="dark" cache="5" }}
	
	- or -
	
	{{ lex.widget.build element="br" widget="examplex:exact" exact="UI Design" }}

	- or -

	{{ lex.widget.build element="span" widget="examplex:exact" exact="Pizza" }}Cookies!</span>
	
	*/
	public function show($options,$content) {
		ci()->load->library('widget');
		
		return ci()->widget->show($options);
	}
	
	public function build($options,$content) {
		ci()->load->library('widget');

		return ci()->widget->widget($options['element'],$options['widget'],$options);		
	}

} /* end class */