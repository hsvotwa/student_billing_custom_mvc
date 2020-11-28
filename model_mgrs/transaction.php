<?php
class TransactionMgr extends BaseMgr {
    public function __construct ( $search_text = "", $invite_list = false ) {
        $this->g_entity_name = "transaction(s)";
        $this->g_retrieve_query = $this->getRetrieveQuery( $search_text,  $invite_list );
    }

    protected function getRetrieveQuery ( $search_text = "" ) {
        return "select *
                   from tbl_transaction
                where name like '%" . $search_text . "%' or code like '%" . $search_text . "%'
                order by code";
   }
}