<?php
class CourseMgr extends BaseMgr {
    public function __construct ( $search_text = "" ) {
        $this->g_entity_name = "course(s)";
        $this->g_retrieve_query = $this->getRetrieveQuery( $search_text );
    }

    protected function getRetrieveQuery ( $search_text ) {
        $query = "select c.*, d.name as department, s.name as status 
                    from tbl_course c
                    inner join tbl_department d on d.uuid = c.department_uuid
                    inner join tbl_lu_status s on s.enum_id = c.status_id
                    where name like '%$search_text%'
                    order by c.name";
        return $query;
    }

    function validName( $name, $uuid ) {
        $query = "select * from tbl_course where name = '$name' and uuid != '$uuid';";
        $data = $this->getMySql()->getQueryResult( $query );
       return ! $data || ! $data->num_rows;
    }
}