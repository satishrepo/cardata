<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Csvreader {

    var $fields;            /** columns names retrieved after parsing */ 
    var $separator = ';';    /** separator used to explode each line */
    var $enclosure = '"';    /** enclosure used to decorate each field */

    var $max_row_size = 4096;    /** maximum row size to be used for decoding */

    function parse_file($p_Filepath, $created_by) {

        $file = fopen($p_Filepath, 'r');
        $this->fields   = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure);
        $keys_values    = explode(',',$this->fields[0]);

        $content        = array();
        $keys           = $this->escape_string($keys_values);

        $i  =   1;
        while( ($row = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure)) != false ) 
        {            
            if( $row != null ) 
            { // skip empty lines
                
                $values =   explode(',',$row[0]);

                if(count($keys) == count($values))
                {
                    $arr        =   array();
                    $new_values =   array();
                    $new_values =   $this->escape_string($values);

                    for($j=0; $j<count($keys); $j++) 
                    {
                        if($keys[$j] != "")
                        {
                            $head = explode('-', $keys[$j]);
                            if(strtolower($head[1]) == 'date') {
                                $new_values[$j] = date('Y-m-d', strtotime($new_values[$j]));
                            }

                            if(strtolower($head[1]) == 'dealer') {
                                $new_values[$j] = $this->getDealer($new_values[$j]);
                            }

                            $arr[strtolower($head[1])] = $new_values[$j];
                            $arr['created_by'] = $created_by;
                        }
                    }

                    $content[$i]    = $arr;
                    $i++;
                }
            }
        }
        fclose($file);
        return $content;
    }

    function escape_string($data){
        $result =   array();
        foreach($data as $row){
            $result[] = str_replace('"', '',$row);
        }
        return $result;
    }

    function getDealer($dealerName) {
        $CI = &get_instance();
        $CI->db->where('name', $dealerName);
        $rs = $CI->db->get('dealers');
        echo $dealerName;
        print_r($rs);
        if(!$rs->num_rows()) {
            $data = array(
                'name' => $dealerName,
                'code' => $dealerName,
                'status' => 1
            );
            $CI->db->insert('dealers', $data);
            return $CI->db->insert_id();
        } else {
            $row = $rs->row_array();
            return $row['id'];
        }
        // return $query->row_array();
    }
}