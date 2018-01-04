<?php

// The name of this module
define('_MI_SUBSCRIPTION_NAME', 'Subscriptions');

// A brief description of this module
define('_MI_SUBSCRIPTION_DESC', 'Member Subscriptions');

// submenu labels.
define('_MI_SUBSCRIPTION_SMNAME1', 'Upgrade Subscription');
define('_MI_SUBSCRIPTION_SMNAME2', 'Cancel Subscription');

// Names of admin menu items
define('_MI_SUBSCRIPTION_ADMIN_MENU_SUBSCRIPTION_INTERVALS', 'Intervals');
define('_MI_SUBSCRIPTION_ADMIN_MENU_SUBSCRIPTION_TYPES', 'Types');
define('_MI_SUBSCRIPTION_ADMIN_MENU_SUBSCRIPTIONS', 'Subscriptions');
define('_MI_SUBSCRIPTION_ADMIN_MENU_GATEWAYS', 'Payment Gateways');
define('_MI_SUBSCRIPTION_ADMIN_MENU_TRANSACTIONS', 'Transactions Report');
define('_MI_SUBSCRIPTION_ADMIN_MENU_SUBS', 'Subscriptions Report');
define('_MI_SUBSCRIPTION_ADMIN_MENU_REMINDERS', 'Email Reminders');
define('_MI_SUBSCRIPTION_ADMIN_MENU_CRON', 'Auto-renew Subscriptions');

define('_MI_ACTIVE_GATEWAY', 'Active Gateway');
define('_MI_ACTIVE_GATEWAY_DESC', 'Payment gateway currently in use.');

define('_MI_DEFAULT_CURRENCY', 'Default Currency');
define('_MI_DEFAULT_CURRENCY_DESC', 'Default currency for payments');

define('_MI_DELAYED_CAPTURE', 'Delayed Capture');
define('_MI_DELAYED_CAPTURE_DESC', 'Manually approve payments before capturing ' . 'funds - Direct Gateways Only');

define('_MI_SSL_ENABLED', 'SSL Enabled');
define('_MI_SSL_ENABLED_DESC', 'SSL Enabled for Direct Payments');
//1.00
//Help
define('_MI_SUBSCRIPTION_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_SUBSCRIPTION_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_SUBSCRIPTION_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_SUBSCRIPTION_OVERVIEW', 'Overview');

//define('_MI_SUBSCRIPTION_HELP_DIR', __DIR__);

//help multi-page
define('_MI_SUBSCRIPTION_DISCLAIMER', 'Disclaimer');
define('_MI_SUBSCRIPTION_LICENSE', 'License');
define('_MI_SUBSCRIPTION_SUPPORT', 'Support');
//define('_MI_SUBSCRIPTION_REQUIREMENTS', 'Requirements');
//define('_MI_SUBSCRIPTION_CREDITS', 'Credits');
//define('_MI_SUBSCRIPTION_HOWTO', 'How To');
//define('_MI_SUBSCRIPTION_UPDATE', 'Update');
//define('_MI_SUBSCRIPTION_INSTALL', 'Install');
//define('_MI_SUBSCRIPTION_HISTORY', 'History');

define('_MI_SUBSCRIPTION_HOME', 'Home');
define('_MI_SUBSCRIPTION_ABOUT', 'About');
