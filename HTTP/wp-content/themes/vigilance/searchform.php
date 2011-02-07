<h2 class="widgettitle">Search</h2>
<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
	<div>
    <input type="text" value="type and press enter" name="s" id="s" onfocus="if (this.value == 'type and press enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'type and press enter';}" />
    <input type="hidden" value="Search" />
  </div>
</form>
