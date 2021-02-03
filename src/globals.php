<?php
// --------------------------------------------------------------------
// Define Global variables For Search
// --------------------------------------------------------------------
define('ADMWPP_SEARCH_PER_PAGE', 10);
define('ADMWPP_SEARCH_DATE_FORMAT', 'mm/dd/yy');

// --------------------------------------------------------------------
// Define Global variables add a selection Block
// --------------------------------------------------------------------
define('ADMWPP_PER_PAGE', 20);

// --------------------------------------------------------------------
// Define Global variable To define the App Environments
// --------------------------------------------------------------------
global $ADMWPP_APP_ENVIRONMENT;
$ADMWPP_APP_ENVIRONMENT = array(
  'production' => array(
    'label' => 'Production',
    'administrate' => 'https://developer.getadministrate.com/',
    'oauthServer' => 'https://auth.getadministrate.com/oauth',
    'apiUri' => 'https://api.administrateapp.com/graphql',
    'weblink' => array(
      'oauthServer' => 'https://portal-auth.administratehq.com',
      'apiUri' => 'https://weblink-api.administratehq.com/graphql/',
    )
  ),
  'staging' => array(
    'label' => 'Staging',
    'administrate' => 'https://developer.stagingadministratehq.com/',
    'oauthServer' => 'https://auth.stagingadministratehq.com/oauth',
    'apiUri' => 'https://api.stagingadministratehq.com/graphql',
    'weblink' => array(
      'oauthServer' => 'https://portal-auth.stagingadministratehq.com',
      'apiUri' => 'https://weblink-api.stagingadministratehq.com/graphql/',
    )
  )
);

// --------------------------------------------------------------------
// Excluded Post types From check-boxes list on settings page
// --------------------------------------------------------------------
global $ADMWPP_EXCLUDED_POST_TYPES;
$ADMWPP_EXCLUDED_POST_TYPES = array(
  'attachment',
  'revision',
  'nav_menu_item',
);

// --------------------------------------------------------------------
// Define Global variables for General Settings page
// --------------------------------------------------------------------
global $ADMWPP_LANG;
$ADMWPP_LANG = array(
  'en_US'  => 'English',
  'fr_FR'  => 'French',
);

define('TMS_SHORT_DESCRIPTION_KEY', 'admwpp_tms_short_descripton');
define('TMS_LANGUAGE_KEY', 'admwpp_tms_language');
define('TMS_STICKY_POST_KEY', 'admwpp_tms_sticky_in_catalog');
define('TMS_CUSTOM_PRICE_LEVEL_NAME', '*KP - 10 kinderen');


global $TMS_COURSE_CONTENT;
$TMS_COURSE_CONTENT = array(
  'admwpp_tms_general_info',
  'admwpp_tms_usps_info',
  'admwpp_tms_price_info',
  'admwpp_tms_practical_info',
);

global $TMS_LP_CUSTOM_FILEDS;
$TMS_LP_CUSTOM_FILEDS = array(
  'admwpp_tms_language' => array(
      'type' => 'text',
      'label' => 'Language',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEzMA==',
  ),
  'admwpp_tms_general_info' => array(
      'type' => 'textarea',
      'label' => 'General Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEyMQ==',
  ),
  'admwpp_tms_usps_info' => array(
      'type' => 'textarea',
      'label' => 'USPs Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEyMg==',
  ),
  'admwpp_tms_price_info' => array(
      'type' => 'textarea',
      'label' => 'Price Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEyMw==',
  ),
  'admwpp_tms_practical_info' => array(
      'type' => 'textarea',
      'label' => 'Practical Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEyNA==',
  ),
  'admwpp_tms_ticket_info' => array(
      'type' => 'text',
      'label' => 'Ticket Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEzNQ==',
  ),
  'admwpp_tms_seat_type' => array(
      'type' => 'text',
      'label' => 'Seat Type',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEzMw==',
  ),
  'admwpp_tms_subtitle' => array(
      'type' => 'text',
      'label' => 'Subtitle',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEzNA==',
  ),
  'admwpp_tms_show_in_catalog' => array(
      'type' => 'text',
      'label' => 'Show in catalog',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEyNg==',
  ),
  'admwpp_tms_sticky_in_catalog' => array(
      'type' => 'text',
      'label' => 'Sticky in catalog',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEyNw==',
  ),
  'admwpp_tms_product_type' => array(
      'type' => 'text',
      'label' => 'Product Type',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEzMg==',
  ),
  'admwpp_tms_target_group' => array(
      'type' => 'text',
      'label' => 'Target Group',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEzMQ==',
  ),
  'admwpp_tms_label' => array(
      'type' => 'text',
      'label' => 'Label',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjEyNQ==',
  ),
);

global $TMS_CUSTOM_FILEDS;
$TMS_CUSTOM_FILEDS = array(
  'admwpp_tms_part_of_day' => array(
      'type' => 'text',
      'label' => 'Part of the Day',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjk3',
  ),
  'admwpp_tms_language' => array(
      'type' => 'text',
      'label' => 'Language',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjg3',
  ),
  'admwpp_tms_target_group' => array(
      'type' => 'text',
      'label' => 'Target Group',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjg4',
  ),
  'admwpp_tms_product_type' => array(
      'type' => 'text',
      'label' => 'Product Type',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjg5',
  ),
  'admwpp_tms_ticket_info' => array(
      'type' => 'text',
      'label' => 'Ticket Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjky',
  ),
  'admwpp_tms_seat_type' => array(
      'type' => 'text',
      'label' => 'Seat Type',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjkw',
  ),
  'admwpp_tms_label' => array(
      'type' => 'text',
      'label' => 'Label',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjgy',
  ),
  'admwpp_tms_subtitle' => array(
      'type' => 'text',
      'label' => 'Subtitle',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjkx',
  ),
  'admwpp_tms_short_descripton' => array(
      'type' => 'textarea',
      'label' => 'Short Description',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOmNvdXJzZS10ZXh0MQ==',
  ),
  'admwpp_tms_general_info' => array(
      'type' => 'textarea',
      'label' => 'General Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOmNvdXJzZS10ZXh0Mg==',
  ),
  'admwpp_tms_usps_info' => array(
      'type' => 'textarea',
      'label' => 'USPs Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOmNvdXJzZS10ZXh0Mw==',
  ),
  'admwpp_tms_price_info' => array(
      'type' => 'textarea',
      'label' => 'Price Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOmNvdXJzZS10ZXh0NA==',
  ),
  'admwpp_tms_practical_info' => array(
      'type' => 'textarea',
      'label' => 'Practical Info',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOmNvdXJzZS10ZXh0NQ==',
  ),
  'admwpp_tms_show_in_catalog' => array(
      'type' => 'text',
      'label' => 'Show in catalog',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjgz',
  ),
  'admwpp_tms_sticky_in_catalog' => array(
      'type' => 'text',
      'label' => 'Sticky in catalog',
      'tmsKey' => 'Q3VzdG9tRmllbGREZWZpbml0aW9uOjg0',
  ),
);
