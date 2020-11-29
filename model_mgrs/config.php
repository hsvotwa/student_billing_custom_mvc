<?php
class ConfigMgr extends BaseMgr {
    public function __construct ( $search_text = "" ) {
        $this->g_entity_name = "Manage config values";
        $this->g_retrieve_query = $this->getRetrieveQuery( $search_text );
    }

    protected function getRetrieveQuery ( $search_text ) {
        $query = "select * from tbl_config
                    order by enum_id";
        return $query;
    }

    public static function getValue( $id ) {
        $configs = ( new ConfigMdl( $id ) )->getAllValues();
        if( ! $configs ) {
            return "";
        }
        return mysqli_fetch_array( $configs )["value"];
    }
}