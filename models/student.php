<?php
class StudentMdl extends BaseMdl {
    public function __construct ( $id = null, $check_profile = true ) {
        $this->g_id = $id;
        $this->g_entity_name = "Student";
        $this->g_sql_table = "tbl_student";
        $this->g_retrieve_query = $this->getRetrieveQuery( $check_profile );
        $this->g_fields = $this->g_invalid_fields = $this->g_errors = array ();
        if ( $id ) {
            $this->retrieve ();
        } else {
            $this->g_id = $this->getMySql()->getUuid();
        }
        $this->getFields();
    }

    protected function getRetrieveQuery( $check_profile = true ) {
        return "select *
                    from $this->g_sql_table u
                where uuid = '$this->g_id'";
    }

    function getSubjects() {
        $query = "select * 
                    from tbl_subject where id in (
                        select subject_id from tbl_student_subject 
                        where student_uuid = '$this->g_id' 
                        and soft_deleted != " . EnumYesNo::yes . "
                    );";
                    echo  $query;
        return $this->getMySql()->getQueryResult( $query );
    }

    function getAids() {
        $query = "select * 
                    from tbl_study_aid where id in (
                        select aid_id from tbl_student_aid 
                        where student_uuid = '$this->g_id' 
                        and soft_deleted != " . EnumYesNo::yes . "
                    );";
        return $this->getMySql()->getQueryResult( $query );
    }

    public function getRecordPageTitle() {
        return ( ! is_null ( $this->g_row ) ? $this->g_entity_name . ': ' . $this->g_row['name']  : 'Register as a ' . $this->g_entity_name );
    }

    public function getFields() {
        if ( $this->g_fields != null ) {
            return $this->g_fields;
        }
        $return = array ();
        $return["name"] = new FieldMdl( 
            "name", "name", "Name", true, EnumFieldDataType::_string, EnumFieldType::_string, $this->g_sql_table, true, "text", $this->g_row
        );
        $return["tel_no"] = new FieldMdl( 
            "tel_no", "tel_no", "Telephone", true, EnumFieldDataType::_string, EnumFieldType::_string, $this->g_sql_table, true, "text", $this->g_row
        );
        $return["email"] = new FieldMdl( 
            "email", "email", "Email", true, EnumFieldDataType::_string, EnumFieldType::_string, $this->g_sql_table, true, "text", $this->g_row
        );
        $this->g_fields = $return;
        return $this->g_fields;
    }
    
    //Subject(s)
    public function studentHasSubject( $subject_id, $student_uuid ) {
        $query = "select * 
                        from tbl_student_subject
                    where subject_id = '$subject_id'
                    and student_uuid = '$student_uuid'
                    and soft_deleted = " . EnumYesNo::no . ";";
        $existing = $this->getMySql()->getQueryResult( $query );
        return $existing && $existing->num_rows;
    }

    public function linkSubject() {
        if( $this->studentHasSubject( $_POST["subject_id"], $_POST["student_uuid"]) ) {
            return true;
        }
        $query = "insert into tbl_student_subject
                    set uuid = uuid(),
                    subject_id = '" . $_POST["subject_id"] . "',
                    student_uuid = '" . $_POST["student_uuid"] . "',
                    soft_deleted = " . EnumYesNo::no . ",
                    created = now(),
                    last_modified = now();";
        return  $this->getMySql()->getQueryResult( $query );
    }

    public function removeSubject( &$error_message ) {
        if( ! $_POST ) {
            return false;
        }
        $query = "update tbl_student_subject
                    set soft_deleted = " . EnumYesNo::yes . ",
                    last_modified = now()
                where uuid = '" . $_POST["student_subject_uuid"] . "';";
       return $this->getMySql()->getQueryResult( $query );
    }

    //Study aid(s)
    public function studentHasAid( $aid_id, $student_uuid ) {
        $query = "select * 
                        from tbl_student_aid
                    where aid_id = '$aid_id'
                    and student_uuid = '$student_uuid'
                    and soft_deleted = " . EnumYesNo::no . ";";
        $existing = $this->getMySql()->getQueryResult( $query );
        return $existing && $existing->num_rows;
    }

    public function linkAid() {
        if( $this->studentHasAid( $_POST["aid_id"], $_POST["student_uuid"] ) ) {
            return true;
        }
        $query = "insert into tbl_student_aid
                    set uuid = uuid(),
                    aid_id = '" . $_POST["aid_id"] . "',
                    student_uuid = '" . $_POST["student_uuid"] . "',
                    soft_deleted = " . EnumYesNo::no . ",
                    created = now(),
                    last_modified = now();";
        return  $this->getMySql()->getQueryResult( $query );
    }

    public function removeAid( &$error_message ) {
        if( ! $_POST ) {
            return false;
        }
        $query = "update tbl_student_aid
                    set soft_deleted = " . EnumYesNo::yes . ",
                    last_modified = now()
                where uuid = '" . $_POST["student_aid_uuid"] . "';";
       return $this->getMySql()->getQueryResult( $query );
    }
}