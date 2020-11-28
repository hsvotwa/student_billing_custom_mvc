<?php
class LecturerMgr extends BaseMgr {
    public function __construct ( $search_text = "" ) {
        $this->g_entity_name = "lecturer(s)";
        $this->g_retrieve_query = $this->getRetrieveQuery( $search_text );
    }

    protected function getRetrieveQuery ( $search_text ) {
        $query = "select * 
                    from tbl_lecturer
                    where name like '%$search_text%'
                    order by name";
        return $query;
    }

    function validName( $name, $uuid ) {
        $query = "select * from tbl_lecturer where name = '$name' and uuid != '$uuid';";
        $data = $this->getMySql()->getQueryResult( $query );
       return ! $data || ! $data->num_rows;
    }
}