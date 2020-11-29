<?php
class SubjectsController extends BaseController {
    public function __construct () {
    }

    function manage() {
        $this->g_can_edit = true;
        $mgr = new SubjectMgr();
        $this->render( "manage", $mgr->getRecordPageTitle() );
    }

    function list( $search_text = "" ) {
        $this->g_can_edit = true;
        $model = new SubjectMgr( $search_text );
        $this->g_layout = null;
        $this->g_form_fields = ( new SubjectMdl( $search_text ) )->getFields();
        $this->g_records = $model->getRecords();
        $this->render("list");
    }
}