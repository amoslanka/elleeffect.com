###############################################
#Theme: October Special                       #
#Designed by: Derek Punsalan                  #
#Search engine optimization by: Neil Patel    #
#Copyrighted by Derek Punsalan and Neil Patel #
###############################################

Tables of Contents
1. Theme Installation
2. Search Engine Optimization Overview
3. Meta Description
4. 301 Permanent Redirect
5. Sitemap

1. Upload the 'octoberspecial' directory to /wp-contents/themes/. Login and navigate to Presentation tab and activate October Special. The theme does support widgets. Download and install the WordPress Widgets plugin here - http://automattic.com/code/widgets/

2. Search Engine Optimization Overview
Currently this theme is optimized for search engines, but there are a few additional things that can be done including a meta description tag, 301 permanent redirect, and creating a sitemap.

3. Meta Description
Search engines usually see your content as duplicate. Granted it usually is not duplicate content, but without a unique meta description tag on each of your posts you are hampering your search engine traffic.

To solve this we can use the head meta description tag. It can be downloaded from http://guff.szub.net/2005/09/01/head-meta-description/ and it is easy to install. That URL contains instructions and I recommend setting the length of the meta description tag to 20 or 25 words.

4. 301 Permanent Redirect
When people link to your blog they usually link to http://domain.com or http://www.domain.com. Because of this the search engines usually see them as two separate sites and you may have 100 sites that link to http://domain.com and 50 sites that link to http://www.domain.com. If the search engines saw it as 150 links in total instead of 50 and 100 your rankings would most likely go up. You want to consolidate the links and do a 301 permanent redirect in your .htaccess file. Here is the code that you may want to use:

Options +FollowSymLinks
RewriteEngine On
RewriteCond %{HTTP_Host} ^YOURDOMAIN\.com [NC]
RewriteRule ^(.*)$ http://www.YOURDOMAIN.com/$1 [L,R=301]

**Make sure the code is on 4 lines in your .htaccess file and replace "YOURDOMAIN" with your domain name.

5. Sitemap
You don't really need a sitemap for your blog, but it will just help get your pages indexed faster. You can create your own HTML sitemap or you can use a WordPress plugin. I recommend using the Google Sitemap generator plugin which can be found at http://www.arnebrachhold.de/2005/06/05/google-sitemaps-generator-v2-final.


