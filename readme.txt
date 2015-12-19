Add Ajax Handler to Controller to handle the ajax calls
which come back from the javascript version of widget

load the library
$this->load->library('widget');

grab the command from the posted input
$command = $this->input->post('command');

send it into the widget request method
$html = $this->widget->request($command);

fill codeigniters output and allow it to be sent
$this->output->set_output($html);

Of course you can put that all in 1 line!

public function widget_handlerPostAction() {
	$this->load->library('widget');

	$this->output->set_output($this->widget->request($this->input->post('command')));
}

Render in PHP before sent to the browser
<?=Widget::show('blog/posts:entry limit="5" sort="publish_on" dir="desc"') ?>

Added to the HTML to have the html loaded dynamically
<command widget="blog/posts:entry" sort="publish_on" dir="desc" wkey="<?=$widget_token ?>">

Added to the HTML to have the above html created dynamically

<?=Widget::command('blog/posts:entry',['limit'=>5,'sort'=>'publish_on','dir'=>'desc']) ?>