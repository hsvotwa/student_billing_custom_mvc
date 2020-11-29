<?php
class ConfigMdl extends BaseMdl {
    public $g_config_values = null;

    public function __construct ( $enum_ids = null ) {
        $this->g_sql_table = "tbl_config";
        $this->g_entity_name = "Configuration";
        $this->g_retrieve_query = $this->getRetrieveQuery( $enum_ids );
        if ( ! is_array( $enum_ids ) ) {
            $enum_ids = array( $enum_ids );
            $this->retrieve();
        }
        $this->g_id = implode( ",", $enum_ids );
        $this->getAll();
    }

    public function getRecordPageTitle() {
        return $this->g_entity_name;
    }

    protected function getAll() {
        if( $this->g_id ) {
            $this->g_config_values = $this->getMySql()->getQueryResult( "select * from $this->g_sql_table where enum_id in( $this->g_id );" );
        } else {
            $this->g_config_values = $this->getMySql()->getQueryResult( "select * from $this->g_sql_table" );
        }
        return $this->g_config_values;
    }

    public static function getAllValues() {
        return ( new ConfigMdl( null ) )->getAll();
    }

    public function save() {
        $values = ConfigMdl::getAllValues();
        $queries = array();
        foreach( $values as $value ) {
                $queries[] = "update tbl_config
                        set value = '" . $_POST[$value["enum_id"]] . "'
                        where enum_id = '" . $value["enum_id"] . "';";
        }
        return  $this->getMySql()->getQueryResult( $queries );
    }

    protected function getRetrieveQuery( $enum_id ) {
       return "select * from $this->g_sql_table where enum_id = $enum_id;" ;
    }

    public function getFields () {
        if ( $this->g_fields != null ) {
            return $this->g_fields;
        }
        $config_values = $this->getAll();
        $return = array ();
        $values = array ();
        $return_main = array ();
        foreach( $config_values as $config_value ) {
            $values[$config_value["enum_id"]] = $config_value["value"];
            $return[$config_value["enum_id"]] = new FieldMdl( 
                $config_value["enum_id"], $config_value["enum_id"], $config_value["name"], true, EnumFieldDataType::_string, EnumFieldType::_string, $this->g_sql_table, true, "text", $values
            );
        }
        $this->g_fields = $return;
        return $this->g_fields;
    }
}