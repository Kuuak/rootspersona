<?php
/*
 * class RP_return connection to database
 *
 * @author: http://phpdao.com
 * @date: 27.11.2007
*/


/**
 * @todo Description of class RP_ConnectionFactory
 * @author ed4becky
 * @copyright 2010-2011  Ed Thompson  (email : ed@ed4becky.org)
 * @version 2.0.x
 * @package rootspersona_php
 * @subpackage
 * @category rootspersona
 * @link www.ed4becky.net
 * @since 2.0.0
 * @license http://www.opensource.org/licenses/GPL-2.0
 */
class RP_Connection_Factory {
	/**
	 * Zwrocenie polaczenia
	 *
	 * @return polaczenie
	 */
	static public function get_connection( $credentials ) {
        $new_link = true;
        $conn = ($GLOBALS["___mysqli_ston"] = mysqli_connect( $credentials->hostname, 
                               $credentials->dbuser, 
                               $credentials->dbpassword));
		if ( ! $conn ) {
			throw new Exception( 'could not connect to database' );
		}
        ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $credentials->dbname));
		mysqli_set_charset( $conn, 'utf8' );
		return $conn;
	}
	/**
	 * Zamkniecie polaczenia
	 *
	 * @param connection polaczenie do bazy
	 */
	static public function close( $connection ) {
		((is_null($___mysqli_res = mysqli_close( $connection ))) ? false : $___mysqli_res);
	}
}
?>
