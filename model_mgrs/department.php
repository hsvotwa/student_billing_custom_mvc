<?php
class DepartmentMgr extends BaseMgr {
    public function __construct ( $search_text = "" ) {
        $this->g_entity_name = "department(s)";
        $this->g_retrieve_query = $this->getRetrieveQuery( $search_text );
    }

    protected function getRetrieveQuery ( $search_text ) {
        $query = "select d.*, s.name as status 
                    from tbl_department d
                    inner join tbl_lu_status s on s.enum_id = c.status_id
                    where name like '%$search_text%'
                    order by d.name";
        return $query;
    }

    function validName( $name, $uuid ) {
        $query = "select * from tbl_department where name = '$name' and uuid != '$uuid';";
        $data = $this->getMySql()->getQueryResult( $query );
       return ! $data || ! $data->num_rows;
    }
}