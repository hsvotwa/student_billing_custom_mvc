<?php
class TransactionMgr extends BaseMgr {
    public function __construct ( $search_text = "", $invite_list = false ) {
        $this->g_entity_name = "transaction(s)";
        $this->g_retrieve_query = $this->getRetrieveQuery( $search_text,  $invite_list );
    }

    protected function getRetrieveQuery ( $search_text = "" ) {
        return "select *, concat(s.surname, ' ', s.first_name, ' (', t.name, ')') as student_name
                   from tbl_student_transaction st
                   inner join tbl_student s on s.uuid = st.student_uuid
                   inner join tbl_lu_title t on t.enum_id = s.title_id
                where s.first_name like '%" . $search_text . "%' or s.surname like '%" . $search_text . "%'
                order by s.surname, s.first_name";
   }
}