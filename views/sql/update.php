<?php
set_time_limit( 0 );
echo '***MySQL update started.***</br>';
echo 'Table structure ' . ( handleAllTableStructure() ? '' : 'not' ) . ' created/updated.</br>';
echo 'Look up data ' . ( handleAllLookupData() ? '' : 'not' ) . ' created/updated.</br>';
echo 'Navigation ' . ( handleAllNavigation() ? '' : 'not' ) . ' created/updated.</br>';
echo 'Other script(s) ' . ( handleOtherScript() ? '' : 'not' ) . ' completed.</br>';
echo '***MySQL update completed.***</br>';
return;

function handleNavigation ( $name, $controller, $action, $sequence, &$uuid = '' ) {
  $mysql = new MySql();
  $uuid = $mysql->getUuid();
  $qry = "insert into tbl_lu_nav
          set uuid = '{$uuid}',
          name = '" . Convert::toString ( $name, true ) . "',
          sequence = {$sequence},
          controller = '" . Convert::toString ( $controller, true ) . "',
          action = '" . Convert::toString ( $action, true ) . "';";
  return $mysql->getQueryResult ( $qry );
}

function handleLookupData ( $table, $enum_id, $name, $other_col = null ) {
  $mysql = new MySql();
  $suffix_qry = '';
  if ( $other_col ) {
      $suffix_qry .= ', ' . $other_col['key'] . '=' . "'" . $other_col['value'] . "'";
  }
  $qry = "select *
              from {$table}
              where ( enum_id = {$enum_id} );";
  $result = $mysql->getQueryResult ( $qry );
  if ( ! $result || ! $mysql->getQueryResult ( $qry )->num_rows ) {
      $qry = "insert into {$table}
                    set name = '{$name}',
                    enum_id = {$enum_id} ";
      $qry .= $suffix_qry;
      return $mysql->getQueryResult ( $qry );
  }
  $qry = "update {$table}
              set name = '{$name}'";
  $qry .= $suffix_qry;
  $qry .= " where enum_id = {$enum_id};" ;
  return $mysql->getQueryResult ( $qry );
}

function handleAllNavigation ( $delete_existing = true ) {
  $mysql = new MySql();
  if ( $delete_existing ) {
    $queries = [
      "delete from tbl_lu_nav;"
    ];
    $mysql->getQueryResult ( $queries );
  }
  $uuid = '';
  $sequence = 0;
  $return = true;
  $return && $return = handleNavigation( 'Students', 'students', 'manage', ++$sequence, $uuid );
  $return && $return = handleNavigation( 'Departments', 'departments', 'manage', ++$sequence, $uuid );
  $return && $return = handleNavigation( 'Courses', 'courses', 'manage', ++ $sequence, $uuid );
  $return && $return = handleNavigation( 'Subjects', 'subjects', 'manage', ++$sequence, $uuid );
  $return && $return = handleNavigation( 'Lecturers', 'lecturers', 'manage', ++$sequence, $uuid );
  $return && $return = handleNavigation( 'Transactions', 'transactions', 'manage', ++$sequence, $uuid );
  return $return;
}

function handleAllLookupData() {
  $mysql = new MySql();
  $return = true;
  $table = "tbl_lu_status";
  $return && $return = handleLookupData ( $table, EnumStatus::active, "Active" );
  $return && $return = handleLookupData ( $table, EnumStatus::inactive, "Inactive" );
  $table = "tbl_lu_title";
  $count = 1;
  $return && $return = handleLookupData ( $table, $count++, "Mr" );
  $return && $return = handleLookupData ( $table, $count++, "Ms" );
  $return && $return = handleLookupData ( $table, $count++, "Mrs" );
  $return && $return = handleLookupData ( $table, $count++, "Dr" );
  $return && $return = handleLookupData ( $table, $count++, "Prof" );
  $return && $return = handleLookupData ( $table, $count++, "Sr" );
  return $return;
}

function handleOtherScript() {
  $mysql = new MySql();
  $queries = [
    "delete from tbl_lu_role_type where enum_id= " . EnumUserRoleType::none
  ];
  if ( empty ( $queries ) ) {
      return true;
  }
  return $mysql->getQueryResult ( $queries );
}

function handleAllTableStructure() {
  $return = true;
  $db_tbl = ( new MySqlTable( "tbl_lu_status") )
              ->addColumn( /*$name = */'enum_id', EnumMySqlColType::tinyint, /*$len = */4, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::primary, /*$auto_increment =*/false )
              ->addColumn( /*$name = */'name', EnumMySqlColType::varchar, /*$len = */50, /*$def = */null, /*$allow_null = */false );
  if ( ! $db_tbl->handle() ) {
    echo "Could not create/alter table: {$db_tbl->getName()} </br>";
    $return = false;
  }
  $db_tbl = ( new MySqlTable( "tbl_lu_title") )
              ->addColumn( /*$name = */'enum_id', EnumMySqlColType::tinyint, /*$len = */4, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::primary, /*$auto_increment =*/false )
              ->addColumn( /*$name = */'name', EnumMySqlColType::varchar, /*$len = */50, /*$def = */null, /*$allow_null = */false );
  if ( ! $db_tbl->handle() ) {
    echo "Could not create/alter table: {$db_tbl->getName()} </br>";
    $return = false;
  }
  $db_tbl = ( new MySqlTable( "tbl_department" ) )
              ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::primary, /*$auto_increment =*/false )
              ->addColumn( /*$name = */'name', EnumMySqlColType::varchar, /*$len = */50, /*$def = */null, /*$allow_null = */false )
              ->addColumn( /*$name = */'status_id', EnumMySqlColType::tinyint, /*$len = */50, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
              ->addColumn( /*$name = */'created', EnumMySqlColType::date_time )
              ->addColumn( /*$name = */'last_modified', EnumMySqlColType::date_time );
  if ( ! $db_tbl->handle() ) {
    echo "Could not create/alter table: {$db_tbl->getName()} </br>";
    $return = false;
  }
  $db_tbl = ( new MySqlTable( "tbl_subject" ) )
                  ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::primary, /*$auto_increment =*/false )
                  ->addColumn( /*$name = */'name', EnumMySqlColType::varchar, /*$len = */50, /*$def = */null, /*$allow_null = */false )
                  ->addColumn( /*$name = */'cost', EnumMySqlColType::decimal, /*$len = */"18,2", /*$def = */0, /*$allow_null = */false )
                  ->addColumn( /*$name = */'created', EnumMySqlColType::date_time )
                  ->addColumn( /*$name = */'last_modified', EnumMySqlColType::date_time );
  if ( ! $db_tbl->handle() ) {
    echo "Could not create/alter table: {$db_tbl->getName()} </br>";
    $return = false;
  }
  $db_tbl = ( new MySqlTable( "tbl_course" ) )
                  ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::primary, /*$auto_increment =*/false )
                  ->addColumn( /*$name = */'name', EnumMySqlColType::varchar, /*$len = */50, /*$def = */null, /*$allow_null = */false )
                  ->addColumn( /*$name = */'department_uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false )
                  ->addColumn( /*$name = */'status_id', EnumMySqlColType::tinyint, /*$len = */50, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                  ->addColumn( /*$name = */'created', EnumMySqlColType::date_time )
                  ->addColumn( /*$name = */'last_modified', EnumMySqlColType::date_time );
  if ( ! $db_tbl->handle() ) {
    echo "Could not create/alter table: {$db_tbl->getName()} </br>";
    $return = false;
  }
   $db_tbl = ( new MySqlTable( "tbl_course_subject_lecturer" ) )
                  ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::primary, /*$auto_increment =*/false )
                  ->addColumn( /*$name = */'course_uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false )
                  ->addColumn( /*$name = */'subject_uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false )
                  ->addColumn( /*$name = */'lecturer_uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                  ->addColumn( /*$name = */'soft_deleted', EnumMySqlColType::tinyint, /*$len = */4, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                  ->addColumn( /*$name = */'created', EnumMySqlColType::date_time )
                  ->addColumn( /*$name = */'last_modified', EnumMySqlColType::date_time );
  if ( ! $db_tbl->handle() ) {
    echo "Could not create/alter table: {$db_tbl->getName()} </br>";
    $return = false;
  }
  $db_tbl = ( new MySqlTable( "tbl_lu_nav" ) )
                  ->addColumn( /*$name = */'id', EnumMySqlColType::_int, /*$len = */11, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::primary, /*$auto_increment =*/true )
                  ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::uniq )
                  ->addColumn( /*$name = */'name', EnumMySqlColType::varchar, /*$len = */100, /*$def = */null, /*$allow_null = */false )
                  ->addColumn( /*$name = */'controller', EnumMySqlColType::varchar, /*$len = */100, /*$def = */null, /*$allow_null = */false )
                  ->addColumn( /*$name = */'action', EnumMySqlColType::varchar, /*$len = */100, /*$def = */null, /*$allow_null = */false )
                  ->addColumn( /*$name = */'sequence', EnumMySqlColType::_int, /*$len = */11, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index );
  if ( ! $db_tbl->handle() ) {
    echo "Could not create/alter table: {$db_tbl->getName()} </br>";
    $return = false;
  }
  $db_tbl = ( new MySqlTable( "tbl_student" ) )
                  ->addColumn( /*$name = */'id', EnumMySqlColType::_int, /*$len = */11, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::primary, /*$auto_increment =*/true )
                  ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::uniq )
                  ->addColumn( /*$name = */'title_id', EnumMySqlColType::tinyint, /*$len = */4, /*$def = */null, /*$allow_null = */false)
                  ->addColumn( /*$name = */'first_name', EnumMySqlColType::varchar, /*$len = */200, /*$def = */null, /*$allow_null = */false)
                  ->addColumn( /*$name = */'surname', EnumMySqlColType::varchar, /*$len = */200, /*$def = */null, /*$allow_null = */false)
                  ->addColumn( /*$name = */'tel_no', EnumMySqlColType::varchar, /*$len = */30, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                  ->addColumn( /*$name = */'email', EnumMySqlColType::varchar, /*$len = */50, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                  ->addColumn( /*$name = */'status_id', EnumMySqlColType::tinyint, /*$len = */50, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                  ->addColumn( /*$name = */'created', EnumMySqlColType::date_time )
                  ->addColumn( /*$name = */'last_modified', EnumMySqlColType::date_time );
    if ( ! $db_tbl->handle() ) {
      echo "Could not create/alter table: {$db_tbl->getName()} </br>";
      $return = false;
    }
    $db_tbl = ( new MySqlTable( "tbl_student_course" ) )
                ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::uniq )
                ->addColumn( /*$name = */'student_uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */true )
                ->addColumn( /*$name = */'course_uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false )
                ->addColumn( /*$name = */'course_cost', EnumMySqlColType::decimal, /*$len = */"18,2", /*$def = */0, /*$allow_null = */false )
                ->addColumn( /*$name = */'soft_deleted', EnumMySqlColType::tinyint, /*$len = */4, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                ->addColumn( /*$name = */'created', EnumMySqlColType::date_time )
                ->addColumn( /*$name = */'last_modified', EnumMySqlColType::date_time );
    if ( ! $db_tbl->handle() ) {
      echo "Could not create/alter table: {$db_tbl->getName()} </br>";
      $return = false;
    }
     $db_tbl = ( new MySqlTable( "tbl_student_transaction" ) )
                ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::uniq )
                ->addColumn( /*$name = */'student_uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */true )
                ->addColumn( /*$name = */'amount', EnumMySqlColType::decimal, /*$len = */"18,2", /*$def = */0, /*$allow_null = */false )
                ->addColumn( /*$name = */'date', EnumMySqlColType::date_time )
                ->addColumn( /*$name = */'soft_deleted', EnumMySqlColType::tinyint, /*$len = */4, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                ->addColumn( /*$name = */'created', EnumMySqlColType::date_time )
                ->addColumn( /*$name = */'last_modified', EnumMySqlColType::date_time );
    if ( ! $db_tbl->handle() ) {
      echo "Could not create/alter table: {$db_tbl->getName()} </br>";
      $return = false;
    }
    $db_tbl = ( new MySqlTable( "tbl_user" ) )
                ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::uniq )
                ->addColumn( /*$name = */'email', EnumMySqlColType::varchar, /*$len = */200, /*$def = */null, /*$allow_null = */true )
                ->addColumn( /*$name = */'name', EnumMySqlColType::varchar, /*$len = */200, /*$def = */null, /*$allow_null = */true )
                ->addColumn( /*$name = */'surname', EnumMySqlColType::varchar, /*$len = */200, /*$def = */null, /*$allow_null = */true )
                ->addColumn( /*$name = */'status_id', EnumMySqlColType::tinyint, /*$len = */4, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                ->addColumn( /*$name = */'created', EnumMySqlColType::date_time )
                ->addColumn( /*$name = */'last_modified', EnumMySqlColType::date_time );
    if ( ! $db_tbl->handle() ) {
      echo "Could not create/alter table: {$db_tbl->getName()} </br>";
      $return = false;
    }
    $db_tbl = ( new MySqlTable( "tbl_lecturer" ) )
                ->addColumn( /*$name = */'uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::uniq )
                ->addColumn( /*$name = */'department_uuid', EnumMySqlColType::char, /*$len = */36, /*$def = */null, /*$allow_null = */false )
                ->addColumn( /*$name = */'full_name', EnumMySqlColType::varchar, /*$len = */200, /*$def = */null, /*$allow_null = */true )
                ->addColumn( /*$name = */'status_id', EnumMySqlColType::tinyint, /*$len = */4, /*$def = */null, /*$allow_null = */false, EnumMySqlIndexType::index )
                ->addColumn( /*$name = */'created', EnumMySqlColType::date_time )
                ->addColumn( /*$name = */'last_modified', EnumMySqlColType::date_time );
    if ( ! $db_tbl->handle() ) {
      echo "Could not create/alter table: {$db_tbl->getName()} </br>";
      $return = false;
    }
    return $return;
  }