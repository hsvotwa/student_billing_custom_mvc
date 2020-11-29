<?php
class LecturerMgr extends BaseMgr {
    public function __construct ( $search_text = "" ) {
        $this->g_entity_name = "lecturer(s)";
        $this->g_retrieve_query = $this->getRetrieveQuery( $search_text );
    }

    protected function getRetrieveQuery ( $search_text ) {
        $query = "select c.*, d.name as department, s.name as status 
                    from tbl_lecturer c
                    inner join tbl_department d on d.uuid = c.department_uuid
                    inner join tbl_lu_status s on s.enum_id = c.status_id
                    where c.full_name like '%$search_text%'
                    order by c.full_name";
        return $query;
    }

    function validName( $name, $uuid ) {
        $query = "select * from tbl_lecturer where name = '$name' and uuid != '$uuid';";
        $data = $this->getMySql()->getQueryResult( $query );
       return ! $data || ! $data->num_rows;
    }
}