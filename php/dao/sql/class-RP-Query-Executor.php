<?php
/**
 * Object executes sql queries
 *
 * @author: http://phpdao.com
 * @date: 27.11.2007
 */
class RP_Query_Executor {
    /**
     * Wykonaniew zapytania do bazy
     *
     * @param sqlQuery obiekt typu SqlQuery
     * @return wynik zapytania
     */
    public static function execute( $sql_query, $credentials = null ) {
        $transaction = RP_Transaction::get_current_transaction();
        if ( ! $transaction ) {
            $connection = new RP_Connection( $credentials );
        } else {
            $connection = $transaction->get_connection();
        }
        $query = $sql_query->get_query();
        $result = $connection->execute_query( $query );
        if ( ! $result ) {
            throw new Exception( ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
        }
        $i = 0;
        $tab = array();
        while ( $row = mysqli_fetch_array( $result ) ) {
            $tab[$i++] = $row;
        }
        ((mysqli_free_result( $result ) || (is_object( $result ) && (get_class( $result ) == "mysqli_result"))) ? true : false);
        if ( ! $transaction ) {
            $connection->close();
        }
        return $tab;
    }


    /**
     * @todo Description of function executeUpdate
     * @param  $sqlQuery
     * @param  $credentials[optional]        default value : null
     * @return
     */
    public static function execute_update( $sql_query, $credentials = null ) {
        $transaction = RP_Transaction::get_current_transaction();
        if ( ! $transaction ) {
            $connection = new RP_Connection( $credentials );
        } else {
            $connection = $transaction->get_connection();
        }
        $query = $sql_query->get_query();
        $result = $connection->execute_query( $query );
        if ( ! $result ) {
            throw new Exception( ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
        }
        return mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
    }


    /**
     * @todo Description of function executeInsert
     * @param  $sqlQuery
     * @param  $credentials[optional]        default value : null
     * @return
     */
    public static function execute_insert( $sql_query, $credentials = null ) {
       RP_Query_Executor::execute_update( $sql_query, $credentials );
        return ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    }
    /**
     * Wykonaniew zapytania do bazy
     *
     * @param sqlQuery obiekt typu SqlQuery
     * @return wynik zapytania
     */
    public static function query_for_string( $sql_query, $credentials = null ) {
        $transaction = RP_Transaction::get_current_transaction();
        if ( ! $transaction ) {
            $connection = new RP_Connection( $credentials );
        } else {
            $connection = $transaction->get_connection();
        }
        $result = $connection->execute_query( $sql_query->get_query() );
        if ( ! $result ) {
            throw new Exception( ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
        }
        $row = mysqli_fetch_array( $result );
        return $row[0];
    }
}
?>
