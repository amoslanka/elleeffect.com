<div id="search">
<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="keyword"><input type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" name="s" id="s" size="17" /></div>
</form>
</div> 