# CF7 Mailgun Domain Validation #
**Contributors:** [macbookandrew](https://profiles.wordpress.org/macbookandrew)  
**Tags:** contact form, contact form 7, cf7, contactform7, validation, mailgun  
**Donate link:** https://cash.me/$AndrewRMinionDesign  
**Requires at least:** 4.8  
Requires PHP
**Tested up to:** 5.0.0  
**Stable tag:** 1.0.2  
**License:** GPL2  

Allows email addresses using your site’s Mailgun domain to pass Contact Form 7’s form validation feature.

## Description ##
Do you use Mailgun to deliver emails from your WordPress site? Does it annoy you that email addresses using the Mailgun domain causes Contact Form 7 validation to fail?

This plugin allows email addresses using your site’s Mailgun domain to pass Contact Form 7’s form validation feature.

It also includes the `cf7_mailgun_domain` filter you can use to modify the default mailgun domain. Example:


	/**
	 * Filter the Mailgun domain.
	 *
	 * @param string $domain Your mailgun domain; defaults to 'mg.your-site.com'.
	 *
	 * @return string Your mailgun domain.
	 */
	function my_custom_mailgun_domain( $domain ) {
		$domain = 'mg.my-site.com'; // Replace this with your Mailgun domain.
		return $domain;
	}
	add_filter( 'cf7_mailgun_domain', 'my_custom_mailgun_domain' );


## Installation ##
1. Install and activate the plugin
1. Revalidate your Contact Form 7 forms.

## Changelog ##

### 1.0.2 ###
- Fix domain filter typo.

### 1.0.1 ###
- Get Mailgun domain from Mailgun plugin options if available.

### 1.0.0 ###
- First stable version
