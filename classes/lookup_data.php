<?php
class LookupData {
    public static function getStatusList() {
        $query = "select 
                    uuid as value, 
                    name 
                from tbl_lu_status
                order by name";
        return ( new MySql() )->getQryRlt( $query );
    }

    public static function getDepartmentList() {
        $query = "select 
                    uuid as value, 
                    name 
                from tbl_department
                where status_id = '" . EnumStatus::active . "'
                order by name";
        return ( new MySql() )->getQryRlt( $query );
    }
}