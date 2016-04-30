Add a Ajax callback to your html pages with optional page token

Example 1 - use the library to build the html tag with default html incase ajax isn't run:

<h1>Hello, my name is <b><?=widget::build('span','examplex:name',['cache'=>60,'format'=>'fullname']) ?>Peter Gunn</span></b></h1>

This is replaced by <span data-widget="examplex:name" data-cache="60" data-format="fullname" data-wkey="01761958959bf64bca078dbeb562785c61c7dac3">

Note:
All options a "optional" in this example they are specifying:
A cache of 60 minutes (of course this can be overridden by the developer in the widget code as needed)
A format option of fullname the widget may have a default (and usually should) incase the designer doesn't specify the value
A wkey (widget key) which is a page specific token only valid for this page request. This insures the page was actually requested and not simply a ajax call without the page request this requirement is configurable

Example 2 - using the <br> tag (which is replaced)

<h1>Hello, my name is <b><?=widget::build('br','examplex:name') ?></b></h1>

This is replaced by <br data-widget="examplex:name"> which is replaced completely with the ajax output

Example 3 - put directly in the HTML

Since many times your designers are building your views and don't normally need to known or understand PHP or about the controller/models. They can add the tags directly to the page

In the above example a designer could add directly to the HTML

<h1>Hello, my name is <b><span data-widget="examplex:name" data-cache="60" data-format="fullname" <?=widget::key() ?>>Peter Gunn</span></b></h1>

or simply

<h1>Hello, my name is <b><span data-widget="examplex:name" data-format="fullname">Peter Gunn</span></b></h1>

If your not using page keys and the developer is controlling the cache length (if any)

This provides the designers with very powerful tools without needing to understand the complex under workings.




