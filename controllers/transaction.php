<?php
class TransactionController extends BaseController {
    public function __construct () {
    }

    function create() {
        $model = new TransactionMdl();
        $this->g_form_fields = $model->getFields();
        $this->g_record_id = $model->g_id;
        $this->g_form_action = WEBROOT . "transaction/save";
        $this->render( "edit", $model->getRecordPageTitle() );
    }

    function edit( $id ) {
        $this->set( array( $id ) );
        $model = new TransactionMdl( $id );
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
        $model = new TransactionMdl( $uuid );
        $model->getFields();
        $error_message = "";
        $soft_deleted = EnumYesNo::no;
        $model->g_additional_sql = " soft_deleted = '$soft_deleted'";
        $success = $model->set();
        if ( $error_message ) {
            $model->g_errors[] = $error_message;
        }
        echo ( new GeneralDisplay() )->deterFeedback( $success, $model->getRecordPageTitle(), implode( ",", $model->g_errors ) );
    }
}