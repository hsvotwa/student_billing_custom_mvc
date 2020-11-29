<?php
class DepartmentController extends BaseController {
    public function __construct () {
    }

    function create() {
        $model = new DepartmentMdl();
        $this->g_form_fields = $model->getFields();
        $this->g_record_id = $model->g_id;
        $this->g_form_action = WEBROOT . "department/save";
        $this->render( "edit", $model->getRecordPageTitle() );
    }

    function edit( $id ) {
        $this->set( array( $id ) );
        $model = new DepartmentMdl( $id );
        if( ! $model->g_row ) {
            ( new ErrorController() )->Error404();
            return;
        }
        $this->g_record_id = $model->g_row["uuid"];
        $this->g_form_fields = ( $model )->getFields();
        $this->render( "edit", $model->getRecordPageTitle() );
    }

    function save() {
        $uuid = (
            isset( $_POST['uuid'] ) && !empty( $_POST['uuid'] )
            ? $_POST['uuid']
            : null
        );
        $model = new DepartmentMdl( $uuid );
        $model->getFields();
        $error_message = "";
        if( ! ( new DepartmentMgr() )->validName( $_POST['name'], $uuid ) ) {
            $data["success"] = false;
            $data["message"] = "The name you provided is already registered for another department.";
            echo json_encode( $data );
            return;
        }
        $success = $model->set();
        if ( $error_message ) {
            $model->g_errors[] = $error_message;
        }
        echo ( new GeneralDisplay() )->deterFeedback( $success, $model->getRecordPageTitle(), implode( ",", $model->g_errors ) );
    }
}