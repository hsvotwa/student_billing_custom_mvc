<?php
class CourseMgr extends BaseMgr {
    public function __construct ( $search_text = "" ) {
        $this->g_entity_name = "course(s)";
        $this->g_retrieve_query = $this->getRetrieveQuery( $search_text );
    }

    protected function getRetrieveQuery ( $search_text ) {
        $query = "select c.*, d.name as department, s.name as status 
                    from tbl_course c
                    inner join tbl_department d on d.uuid = c.department_uuid
                    inner join tbl_lu_status s on s.enum_id = c.status_id
                    where c.name like '%$search_text%'
                    order by c.name";
        return $query;
    }

    public static function getCost( $course_uuid ) {
        $query = "select ifnull(sum(cost), 0) total_cost
                    from tbl_subject where uuid in (
                    select subject_uuid from tbl_course_subject_lecturer where course_uuid ='$course_uuid' and 
                        soft_deleted != " . EnumYesNo::yes . "
                )";
        $data = ( new MySql() )->getQueryResult( $query );
        if( ! $data || ! $data->num_rows ) {
            return 0;
        }
        $data = mysqli_fetch_array( $data );
        $vat = ConfigMgr::getValue( EnumConfig::vat );
        return $vat && is_numeric( $vat ) ? 
            $data["total_cost"] * ( ( 100 + $vat ) / 100 )  : 
            $data["total_cost"];
    }

    function validName( $name, $uuid ) {
        $query = "select * from tbl_course where name = '$name' and uuid != '$uuid';";
        $data = $this->getMySql()->getQueryResult( $query );
       return ! $data || ! $data->num_rows;
    }
}