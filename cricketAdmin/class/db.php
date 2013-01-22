<?
/*
define('DB_SERVER','localhost');
define('DB_USERNAME','pavanrat_pavan');
define('DB_PASSWORD','28pepsy1998');
define('DB_DATABASE','pavanrat_main');

define('DB_SERVER','mysql01.manashosting.biz');
define('DB_USERNAME','pavan_pepsy');
define('DB_PASSWORD','28pepsy1986');
define('DB_DATABASE','pavan_feedback');

define('DB_SERVER','localhost');
define('DB_USERNAME','pavanrat_pavan');
define('DB_PASSWORD','28pepsy1998');
define('DB_DATABASE','pavanrat_main');

define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_DATABASE','test');
*/

define('DB_SERVER','localhost');
define('DB_USERNAME','pavanrat_pavan');
define('DB_PASSWORD','28pepsy1998');
define('DB_DATABASE','pavanrat_main');
define('REGISTER','cricket_register');
define('TEAM','team_owner');
define('TEAM_NAME','team');
define('FIXTURE','fixture');
define('BATTING','batting_stats');
class DB
{
	private $connection;
	function __construct()
	{
		$connection=mysql_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD) or die('We are facing some technical issue.Please try later on.');
		mysql_select_db(DB_DATABASE,$connection) or die('We are facing some technical issue.Please try later on.');
	}
	function __destruct()
	{
		//mysql_close($connection);
	}
}
?>