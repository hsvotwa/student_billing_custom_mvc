<?php
class LookupData {
    public static function getStatusList() {
        $query = "select 
                    enum_id as value, 
                    name 
                from tbl_lu_status
                order by name";
        return ( new MySql() )->getQryRlt( $query );
    }

    public static function getAllStudents() {
        $query = "select 
                    s.uuid as value, 
                    concat(s.surname, ' ', s.first_name, ' (', t.name, ')') as name
                from tbl_student s
                inner join tbl_lu_title t on t.enum_id = s.title_id
                order by s.surname, s.first_name";
        return ( new MySql() )->getQryRlt( $query );
    }

    public static function getTitleList() {
        $query = "select 
                    enum_id as value, 
                    name 
                from tbl_lu_title
                order by name";
        return ( new MySql() )->getQryRlt( $query );
    }

    public static function getSubjectList() {
        $query = "select 
                    uuid as value, 
                    name 
                from tbl_subject
                order by name";
        return ( new MySql() )->getQryRlt( $query );
    }

    public static function getDepartmentList() {
        $query = "select 
                    uuid as value, 
                    name 
                from tbl_department
                where status_id = '" . EnumStatus::active . "'
                order by name";
        return ( new MySql() )->getQryRlt( $query );
    }

    public static function getCourseList() {
        $query = "select 
                    uuid as value, 
                    name 
                from tbl_course
                where status_id = '" . EnumStatus::active . "'
                order by name";
        return ( new MySql() )->getQryRlt( $query );
    }

    public static function getLecturerList() {
        $query = "select 
                    uuid as value, 
                    full_name as name 
                from tbl_lecturer
                where status_id = '" . EnumStatus::active . "'
                order by full_name";
        return ( new MySql() )->getQryRlt( $query );
    }
}