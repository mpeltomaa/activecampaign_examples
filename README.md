[![Code Climate](https://codeclimate.com/github/mpeltomaa/activecampaign_examples/badges/gpa.svg)](https://codeclimate.com/github/mpeltomaa/activecampaign_examples)

# How to use Active Campaign with Campwire Thank you -page

## Add contact to list
File: AddContactToList.php

This code will add new contact to your list. If contact is already in your Active Campaign code will also attempt to change firstname and lastname.

### Requirements
- Your Active Campaign URL
- Your Active Campaign API key
- Your list ID
- Curl for PHP

### Active Campaign API key and URL
- Sign in to your Active Campaign account and open My Settings.
- Choose **Developer** from left menu.
- Your _url_ and _api key_ can be found from **API Access** section.

### Active Campaign List ID
- While you are logged in to Active Campaign, choose Lists from top menu
- Create a new list or search already created list
- Open up your list and checkout url on your browser, it should be something like: `https://xxxx.activehosted.com/app/contacts/?listid=9999&status=1`. listid = 9999 is your list ID (in this case your list ID is 9999).

### Curl and your server
Curl extension for PHP is needed to get things rolling. If you don't have it already you can easily install it.

**CentOS**

`sudo yum install php-curl`

**Ubuntu**

`sudo apt-get install php-curl`


### How to use code
- Fill in your own URL, listID and API Key at the start of the code.

#### Wordpress
If you are using Wordpress you can easily drop in this code to existing page. Example structure:

```
<?php get_header(); ?>
  <!-- Start of your normal page content -->
  <div>
    Here goes your normal page content.
  </div>

  <!-- Copy paste contents of AddContactToList.php here -->

  <!-- Add sidebar if you use one... ->
  <?php get_sidebar(); ?>

  <!-- Add footer -->
  <?php get_footer(); ?>
```
