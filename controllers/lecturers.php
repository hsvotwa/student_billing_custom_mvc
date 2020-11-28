<?php
class LecturersController extends BaseController {
    public function __construct () {
    }

    function manage() {
        $this->g_can_edit = true;
        $mgr = new LecturerMgr();
        $this->render( "manage", $mgr->getRecordPageTitle() );
    }

    function list( $search_text ) {
        $this->g_can_edit = true;
        $model = new LecturerMgr( "", $search_text );
        $this->g_layout = null;
        $this->g_form_fields = ( new LecturerMdl() )->getFields();
        $this->g_records = $model->getRecords();
        $this->render("list");
    }
}