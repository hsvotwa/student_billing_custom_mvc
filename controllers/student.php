<?php
class StudentController extends BaseController {
    public function __construct () {
    }

    function create() {
        $model = new StudentMdl();
        $this->g_form_fields = $model->getFields();
        $this->g_record_id = $model->g_id;
        $this->g_form_action = WEBROOT . "student/save";
        $this->render( "edit", $model->getRecordPageTitle() );
    }

    function edit( $id ) {
        $this->set( array( $id ) );
        $model = new StudentMdl( $id );
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
        $model = new StudentMdl( $uuid );
        $model->getFields();
        $error_message = "";
        if( ! ( new StudentMgr() )->validEmail( $_POST['email'], $uuid ) ) {
            $data["success"] = false;
            $data["message"] = "The email you provided is already registered for another student.";
            echo json_encode( $data );
            return;
        }
        $success = $model->set();
        if ( $error_message ) {
            $model->g_errors[] = $error_message;
        }
        echo ( new GeneralDisplay() )->deterFeedback( $success, $model->getRecordPageTitle(), implode( ",", $model->g_errors ) );
    }

    function createcourse() {
        if( ! ( new UserMdl() )->hasAccessTo( EnumUserRoleType::manage_course ) ) {
            echo ( new GeneralDisplay() )->deterFeedback( false, "", UNAUTHORISED_MESSAGE );
            return;
        }
        $model = new StudentCourseMdl();
        $this->g_form_fields = $model->getFields();
        $this->g_record_id = $model->g_id;
        $this->g_layout = null;
        $this->g_form_action = WEBROOT . "student/savecourse";
        $this->render( "studentcourse", $model->getRecordPageTitle() );
    }

    function savecourse() {
        $model = new StudentCourseMdl();
        $model->getFields();
        $error = "";
        $success = $model->save( $error );
        echo ( new GeneralDisplay() )->deterFeedback( $success, "", $error );
    }

    function removecourse() {
        $model = new StudentCourseMdl();
        $model->getFields();
        $message = "";
        $success = $model->remove( $message );
        echo ( new GeneralDisplay() )->deterFeedback( $success, "", $message );
    }
}