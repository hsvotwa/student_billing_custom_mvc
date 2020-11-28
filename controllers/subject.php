<?php
class SubjectController extends BaseController {
    public function __construct () {
    }

    function create() {
        $model = new SubjectMdl();
        $this->g_form_fields = $model->getFields();
        $this->g_record_id = $model->g_id;
        $this->g_form_action = WEBROOT . "subject/save";
        $this->render( "edit", $model->getRecordPageTitle() );
    }

    function edit( $id ) {
        $this->set( array( $id ) );
        $model = new SubjectMdl( $id );
        if( ! $model->g_row ) {
            ( new ErrorController() )->Error404();
            return;
        }
        $this->g_record_id = $model->g_row["uuid"];
        $this->g_form_fields = ( $model )->getFields();
        $this->render( "edit", $model->getRecordPageTitle() );
    }

    function detail( $id ) {
        $this->set( array( $id ) );
        $model = new SubjectMdl( $id );
        if( ! $model->g_row ) {
            ( new ErrorController() )->Error404();
            return;
        }
        $this->g_record_id = $model->g_row["uuid"];
        $this->g_form_fields = ( $model )->getFields();
        $this->render( "detail", $model->getRecordPageTitle() );
    }

    function save() {
        $uuid = (
            isset( $_POST['uuid'] ) && !empty( $_POST['uuid'] )
            ? $_POST['uuid']
            : null
        );
        $model = new SubjectMdl( $uuid );
        $model->getFields();
        $error_message = "";
        if( ! ( new SubjectMgr() )->validIdNum( $_POST['id_no'], $uuid ) ) {
            $data["success"] = false;
            $data["message"] = "The ID number you provided is already registered for another subject.";
            echo json_encode( $data );
            return;
        }
        $success = $model->set() && $model->pushToBCTime( $error_message );
        if ( $error_message ) {
            $model->g_errors[] = $error_message;
        }
        echo ( new GeneralDisplay() )->deterFeedback( $success, $model->getRecordPageTitle(), implode( ",", $model->g_errors ) );
    }
}