<?php



require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$application = 'frontend';
$env = 'prod';


if ($_SERVER['HTTP_HOST'] == 'admin.citation-et-proverbe.fr')
{

  /* authentification pour tests */
  function auth() {
     header('WWW-Authenticate: Basic realm="Citations"');
     header('HTTP/1.0 401 Unauthorized');
     print 'authorisation required';
     exit;
  }

  function checkLogin($login, $pass) {
    if (($login == 'admin') && ($pass == 'nenuhy@uqaperema'))
      return true;
    else
      return false;
  }

  if (true) {
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
       auth();
    } else {
       if(! checkLogin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
          auth();
       }
    }
  }
  /* fin authentification pour tests */

	$application = 'backend';
} 

$enddomaine = substr($_SERVER['HTTP_HOST'], strrpos($_SERVER['HTTP_HOST'], '.')+1);
if ($enddomaine == 'dev') {
	$env = 'dev';
}
if ($_SERVER['HTTP_HOST'] == 'admin.citation-et-proverbe.fr.dev')
{
	$application = 'backend';
}

$configuration = ProjectConfiguration::getApplicationConfiguration($application, $env, $env != prod);
sfContext::createInstance($configuration)->dispatch();
