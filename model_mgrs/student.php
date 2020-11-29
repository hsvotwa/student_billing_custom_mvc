<?php
class StudentMgr extends BaseMgr {
    public function __construct( $search_text = "") {
        $this->g_entity_name = "student(es)";
        $this->g_retrieve_query = $this->getRetrieveQuery( $search_text );
    }

    protected function getRetrieveQuery( $search_text ) {
        return "select st.*, s.name as status, t.name as title 
                from tbl_student st
                inner join tbl_lu_status s on s.enum_id = st.status_id
                inner join tbl_lu_title t on t.enum_id = st.title_id
                where ( st.first_name like '%$search_text%' or st.surname like '%$search_text%'
                        or st.email like '%$search_text%' )
                order by st.first_name";
    }

    public function getNextStudentNumber() {
        $query = "select ifnull(count(uuid), 0) + 1 as student_count
                from tbl_student
                order by name";
        $data = $this->getMySql()->getQueryResult( $query );
       if( ! $data || ! $data->num_rows ) {
           return "S0001";
       }
       $data = mysqli_fetch_array( $data );
       return str_pad( $data["student_count"], 4, '0', STR_PAD_RIGHT );
    }

    function validEmail( $email, $uuid ) {
        $query = "select * from tbl_student where email = '$email' and uuid != '$uuid';";
        $data = $this->getMySql()->getQueryResult( $query );
       return ! $data || ! $data->num_rows;
    }
}