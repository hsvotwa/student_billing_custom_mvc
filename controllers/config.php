<?php
class ConfigController extends BaseController {
    public function __construct () {
    }

    function create() {
        $model = new ConfigMdl();
        $this->g_form_fields = $model->getFields();
        $this->g_record_id = $model->g_id;
        $this->g_form_action = WEBROOT . "config/save";
        $this->render( "edit", $model->getRecordPageTitle() );
    }

    function edit() {
        $model = new ConfigMdl( );
        $this->g_record_id = $model->g_row["uuid"];
        $this->g_form_fields = ( $model )->getFields();
        $this->render( "edit", $model->getRecordPageTitle() );
    }

    function save() {
        $model = new ConfigMdl();
        $model->getFields();
        $error_message = "";
        $success = $model->save();
        echo ( new GeneralDisplay() )->deterFeedback( $success,"", null );
    }
}