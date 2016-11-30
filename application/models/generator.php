<?php
    /**
     *  Script super sederhana buat generate model di CodeIgniter dari database
     */
	 $host = "172.30.1.6";
	 $port = 3306;
	 $user = "root";
	 $pass = "m3iag2k9";
    $db_name = "lottar";

    $conn = mysql_connect($host, $user, $pass);
    mysql_select_db($db_name);

    $sql = "select table_name from information_schema.tables where table_schema='$db_name'";
    $result = mysql_query($sql);

    while(($row = mysql_fetch_assoc($result)))
    {
        $tb_name = $row['table_name'];
        $sql = "select column_name, column_key, extra from information_schema.columns where table_schema='$db_name' and table_name='$tb_name'";
        $result_column = mysql_query($sql);

        $ftable = fopen(ucfirst($tb_name) . "_model.php", "w");
        $str = "<?php\n";
        $str .= "class " . ucfirst($tb_name) . "_model extends Model\n{\n\n\t";
        $str .= "function " . ucfirst($tb_name) . "_model()\n\t{\n\t\t";
        $str .= "parent::Model();\n\t\t\$this->load->database();\n\t}\n\n\t";
        fwrite($ftable, $str);

        $str_create  = "function create(\$data)\n\t{\n\t\t";
        $str_update  = "function update(\$id, \$data)\n\t{\n\t\t";
        $str_read    = "function get_by_id(\$id)\n\t{\n\t\t";
        $str_readAll = "function get_all()\n\t{\n\t\t";
        $str_delete  = "function delete(\$id)\n\t{\n\t\t";
        
        while($row_column = mysql_fetch_assoc($result_column))
        {
            if($row_column["extra"] != "auto_increment")
            {
                $str_create .= "\$this->db->set('" . $row_column['column_name'] . "', \$data['" . $row_column['column_name'] . "']);\n\t\t";
            }
            if($row_column["column_key"] != "PRI")
            {
            	 $str_update .= "if(\$data['". $row_column['column_name'] ."'])\n\t\t\t";
                $str_update .= "\$this->db->set('" . $row_column['column_name'] . "', \$data['" . $row_column['column_name'] . "']);\n\t\t";
            }
            else
            {
                $str_update 	.= "\$this->db->where('" . $row_column['column_name'] . "', \$id);\n\t\t";
                $str_read 		.= "\$this->db->where('" . $row_column['column_name'] . "', \$id);\n\t\t";
                $str_delete 	.= "\$this->db->where('" . $row_column['column_name'] . "', \$id);\n\t\t";
            }
        }

        $str_create .= "\$this->db->insert('" . strtolower($tb_name) . "');\n\n\t\t";
        $str_create .= "return \$this->db->inserted_id();\n\t}\n\n\t";
        $str_update .= "\$this->db->update('" . strtolower($tb_name) . "');\n\n\t\t";
        $str_update .= "return \$this->db->affected_rows();\n\t}\n\n\t";
        $str_delete .= "\$this->db->delete('" . strtolower($tb_name) . "');\n\n\t\t";
        $str_delete .= "return \$this->db->affected_rows();\n\t}\n\n";
        $str_read .= "\$query = \$this->db->get('" . strtolower($tb_name) . "');\n\n\t\t";
        $str_read .= "return \$query->row();\n\t}\n\n\t";
        $str_readAll .= "\$query = \$this->db->get('" . strtolower($tb_name) . "');\n\n\t\t";
        $str_readAll .= "return \$query->result();\n\t}\n\n\t";

        fwrite($ftable, $str_create);
        fwrite($ftable, $str_read);
        fwrite($ftable, $str_readAll);
        fwrite($ftable, $str_update);
        fwrite($ftable, $str_delete);
        fwrite($ftable, "}");

        fclose($ftable);
    }
?>