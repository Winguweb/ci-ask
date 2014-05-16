<?php defined('SYSPATH') or die('No direct script access.');
/**
* Ci_Ask main settings model
*
*/

class Ci_Ask_Model extends ORM
{
	// Database table name
	protected $table_name = 'ci_ask';
	
	/*public static function get_asks($where = array(), $limit = NULL, $order_field = NULL, $sort = NULL, $count = FALSE)
	{
		// Get the table prefix
		$table_prefix = Kohana::config('database.default.table_prefix');

		// To store radius parameters
		$radius = array();
		// Query
		// Normal query
		if (! $count)
		{
			$sql = 'SELECT DISTINCT i.id incident_id, i.incident_title, i.incident_description, i.incident_date, i.incident_mode, i.incident_active, '
				. 'i.incident_verified, i.location_id, l.country_id, l.location_name, l.latitude, l.longitude ';
		}
		// Count query
		else
		{
			$sql = 'SELECT COUNT(DISTINCT i.id) as report_count ';
		}
		
		
		$sql .=  'FROM '.$table_prefix.'incident i '
			. 'LEFT JOIN '.$table_prefix.'location l ON (i.location_id = l.id) '
			. 'LEFT JOIN '.$table_prefix.'incident_category ic ON (ic.incident_id = i.id) '
			. 'LEFT JOIN '.$table_prefix.'category c ON (ic.category_id = c.id) ';


		// Check for the order field and sort parameters
		if ( ! empty($order_field) AND ! empty($sort) AND (strtoupper($sort) == 'ASC' OR strtoupper($sort) == 'DESC'))
		{
			$sql .= 'ORDER BY '.$order_field.' '.$sort.' ';
		}
		else
		{
			$sql .= 'ORDER BY i.incident_date DESC ';
		}

		// Check if the record limit has been specified
		if ( ! empty($limit) AND is_int($limit) AND intval($limit) > 0)
		{
			$sql .= 'LIMIT 0, '.$limit;
		}
		elseif ( ! empty($limit) AND $limit instanceof Pagination_Core)
		{
			$sql .= 'LIMIT '.$limit->sql_offset.', '.$limit->items_per_page;
		}

		// Event to alter SQL
		Event::run('ushahidi_filter.get_incidents_sql', $sql);

		// Kohana::log('debug', $sql);
		return Database::instance()->query($sql);
	}*/
}
