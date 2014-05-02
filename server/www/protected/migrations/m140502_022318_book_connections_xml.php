<?php

/** 
 * Adds a connections xml column to the books table.
 *
 * @author Alex Berriman <alex@ajberri.com>
 */
 
class m140502_022318_book_connections_xml extends CDbMigration
{
    // Add the column
	public function up()
	{
        $this->addColumn('{{book}}', 'connections_xml', 
            'LONGTEXT DEFAULT NULL');
	}

    // Remove the column
	public function down()
	{
		$this->dropColumn('{{book}}', 'connections_xml');
	}
}