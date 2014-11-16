<?php
/*
	This is the database connection information.
	Please do not commit this to a git repository.
*/
namespace EEMS;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider;

class DoctrineConnection implements ServiceProviderInterface
{
    public function register(Application $app)
    {
    	$dbConnection = array(
	    'path' => dirname(dirname(dirname(__FILE__))) . "/database.sqlite",
	    'driver' => 'pdo_sqlite'
	            );
    	$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
		    'db.options' => $dbConnection
		));
    }
    public function boot(Application $app)
    {
    }
}