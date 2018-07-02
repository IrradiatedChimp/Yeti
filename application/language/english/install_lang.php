<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Headers */
$lang['mysql_header'] = 'MySQL Database Connection';
$lang['database_header'] = 'Database Creation';
$lang['tables_header'] = 'Table Creation';
$lang['finish_header'] = 'Finish Installation';

/* Breadcrumbs */
$lang['breadcrumb_mysql'] = 'MySQL connection';
$lang['breadcrumb_database'] = 'Database creation';
$lang['breadcrumb_table'] = 'Tables creation';
$lang['breadcrumb_site'] = 'Site settings';
$lang['breadcrumb_finish'] = 'Finish installation';

/* Text */
$lang['step2'] = 'Please enter a name for the database that will host your forums tables.<br>The database will be created <strong>Automatically</strong> for you.<br>';

/* Forms */
$lang['db_hostname'] = 'Hostname';
$lang['db_username'] = 'Username';
$lang['db_password'] = 'Password';

/* Form Placeholders */
$lang['db_hostname_placeholder'] = 'Enter your MySQL hostname';
$lang['db_username_placeholder'] = 'Enter your MySQL username';
$lang['db_password_placeholder'] = 'Enter your MySQL password';

/* Buttons */
$lang['button_continue'] = 'Continue';

/* Messages */
$lang['install_hostname_error'] = 'The <strong>hostname</strong> could not be replaced in your <strong>application/config/database.php</strong> config file. Please try again.';
$lang['install_username_error'] = 'The <strong>username</strong> could not be replaced in your <strong>application/config/database.php</strong> config file. Please try again.';
$lang['install_password_error'] = 'The <strong>password</strong> could not be replaced in your <strong>application/config/database.php</strong> config file. Please try again.';
$lang['install_database_test_error'] = 'Could not connect to MySQL with the details provided.  Please check your <strong>hostname</strong>, <strong>Username</strong> & <strong>Password</strong> and try again.';
$lang['install_database_error'] = 'There was a problem creating the new database. Please try again.';
$lang['install_tables_error'] = 'There was a problem generating the database tables. Please try again.';
