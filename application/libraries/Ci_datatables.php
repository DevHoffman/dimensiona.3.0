<?php

/**
 * Author: Alexandre
 * Date: 22/07/2017
 *
 * Class CI_DataTables
 */
Class CI_datatables
{
    protected $CI;

    /**
     * CI_DataTables constructor.
     */
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * @param $dtObject
     * @param $table
     * @param $columns
     * @param null $join
     * @param null $where
     * @return array
     */
    public function exec($dtObject, $table, $columns, $join = NULL, $where = NULL, $group = null)
    {
        $db = $this->CI->db;

        $db->start_cache();

        # set columns show
        $cols = '';
        foreach ($columns as $c) {
            $cols .= $c['db'] . ' AS ' . $c['dt'] . ',';
        }

        # select...
        $db->select(rtrim($cols, ','));

        # set main table
        $db->from($table);

        # join tables
        if (isset($join)) {
            foreach ($join as $j) {
                $type = (isset($j[2])) ? $j[2] : 'INNER';
                $db->join($j[0], $j[1], $type);
            }
        }

        # datatable search columns
        if (isset($dtObject['columns'])) {
            $_columns = $dtObject['columns'];

            # global like filter
            if (!empty($dtObject['search']['value'])) {
                $db->group_start();
                foreach ($dtObject['columns'] as $column) {
                    if ($column['searchable'] == 'true') $db->or_like($column['name'], (is_numeric($dtObject['search']['value'])) ? intval($dtObject['search']['value']) : $dtObject['search']['value']);
                }
                $db->group_end();
            }

            # individual search
            foreach ($dtObject['columns'] as $column) {
                if ($column['searchable'] == 'true' AND ($column['search']['value'] !== '')) {
                    if (isset($column['search']['type'])) {
                        $col = $column['name'];
                        $val = explode(',', $column['search']['value']);
                        switch ($column['search']['type']) {
                            case  'equal' :
                                $db->where($col, $column['search']['value']);
                                break;
                            case  'in' :
                                $db->where_in($col, $val);
                                break;
                            case  'or_in' :
                                $db->or_where_in($col, $val);
                                break;
                            case  'not_in' :
                                $db->where_not_in($col, $val);
                                break;
                            case  'or_not_in' :
                                $db->or_where_not_in($col, $val);
                                break;
                            case  'between' :
                                list($d1, $d2) = $val;
                                if (isset($d1) && isset($d2)) $db->where("{$col} BETWEEN '{$d1}' AND '{$d2}'");
                                break;
                            case 'date':
                                list($d1, $d2) = $val;
                                if (isset($d1) && isset($d2)) $db->where("DATE({$col}) BETWEEN '{$d1}' AND '{$d2}'");
                                break;
                        }
                    } else {
                        $db->like($column['name'], $column['search']['value']);
                    }
                }
            }
        }

        #echo $db->get_compiled_select();exit();

        # where tables
        if (isset($where)) {
            $db->where($where);
        }

        #group_by

        if (isset($group)){
            $db->group_by($group);
        }


        # total record find
        $db->stop_cache();
        $recordsFiltered = $db->count_all_results();

        # limits (paging)
        if (isset($dtObject['start']) && $dtObject['length'] && $dtObject['length'] > 0) {
            $db->limit($dtObject['length'], $dtObject['start']);
        }

        # order
        if (isset($dtObject['order'])) {
            foreach ($dtObject['order'] as $order) {
                if (isset($_columns)) $db->order_by($_columns[$order['column']]['name'], $order['dir']);
            }
        }

        # query
        $query = $db->get();
        // var_dump($db->last_query());exit(); 
        $rows = $query->result_array();
        $recordsTotal = $db->count_all_results($table);


        $query->free_result();
        $db->flush_cache();

        # output format
        $output = array();
        foreach ($rows as $k => $row) {
            foreach ($columns as $c) {
                if (isset($c['formatter'])) {
                    $output[$k][$c['dt']] = $c['formatter']($row[$c['dt']], $row);
                } else {
                    $output[$k][$c['dt']] = $row[$c['dt']];
                }
            }
        }

        # object return
        return array(
            "draw" => isset ($dtObject['draw']) ? intval($dtObject['draw']) : 0,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $output
        );
    }
}
