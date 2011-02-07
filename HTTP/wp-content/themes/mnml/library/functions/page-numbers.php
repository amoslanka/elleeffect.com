<?php

// Get the page number
function pageGetPageNo()
{
    if (get_query_var('paged'))
    {
        print ' | Page ' . get_query_var('paged');
    }
}

?>