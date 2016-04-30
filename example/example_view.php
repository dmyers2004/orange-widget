
<h1>Using PHP to build the html element</h1>

<h3>Hello, my name is <b><?=widget::build('span','examplex:name',['cache'=>60,'format'=>'fullname']) ?>Peter Gunn</span></b>.<br/>I develop for the web.</h3>

<h3><?=widget::build('br','examplex:br',['cache'=>60,'format'=>'fullname']) ?></span></h3>

<h1>Entering the HTML element directly - which actually yields slightly faster performance since PHP doesn't need to build the link</h1>

<h3><br data-widget="examplex:method_option" data-option="1" <?=widget::key() ?>></h3>

<h3><br data-widget="examplex:method_option" data-option="12"></h3>

<h3><span data-widget="examplex:method_option" data-option="8">Replace Me!</span></h3>