<table class="tbl_cont">
    <tr>
        <td class="tbl_cont_td_2">
            <div class="div_filter">
                <?php 
                    if( $can_edit ) {
                        echo '<a href="' . APP_DOMAIN . 'department/create/" class="button">Create new</a>';
                    }
                ?>
                <input type="search" name="search" id="search" class="text" placeholder="Search department(s)..." />&nbsp;
                <a href="#" class="url" id="refresh_link">refresh</a>
            </div>
            <table class="tbl_cont_data tbl_cont_data_filter" id="record_list">

            </table>
        </td>
    </tr>
</table>
<?php
    echo $gen->getJavascriptRef('js/departments.js')
?>