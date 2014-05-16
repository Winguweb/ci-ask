<?php
class My_plugin_name_Install {
 
    /**
     * Constructor to load the shared database library
     */
    public function __construct()
    {
        $this->db =  new Database();
    }
 
    /**
     * Creates the required database tables for my_plugin_name
     */
    public function run_install()
    {
        // Create the database tables
        // Include the table_prefix
		$this->db->query("
	
				CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."ci_ask`
					(
					  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `author` varchar(256) NOT NULL,
					  `email` varchar(256) NOT NULL,
					  `phone` varchar(32) NOT NULL,
					  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `subject` varchar(256) NOT NULL,
					  `message` text NOT NULL,
					  `reply` int(11) NOT NULL DEFAULT '0',
					  `category` varchar(256) NOT NULL,
					  `file_link` varchar(256) NOT NULL,
					  PRIMARY KEY (`id`)
					);
				");
				
		$this->db->query("
				CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."ci_ask_categories`
					(
						`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						`name` varchar(256) NOT NULL,
						PRIMARY KEY (`id`)
					);
				");
            
    }
 
    /**
     * Deletes the database tables for my_plugin_name
     */
    public function uninstall()
    {
        //$this->db->query("
        //    DROP TABLE ".Kohana::config('database.default.table_prefix')."jasd_table;
        //    ");
    }
}
?>
