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
*/
class Widget_handlerController extends O_AjackController {

	public function indexPostAction() {
		$this->load->library('widget');

		$this->output->set_output($this->widget->request($this->input->post('options')));
	}

} /* end controller */