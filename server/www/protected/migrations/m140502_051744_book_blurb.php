<?php

/** 
 * Adds a blurb column to the books table.
 *
 * @author Alex Berriman <alex@ajberri.com>
 */
 
class m140502_051744_book_blurb extends CDbMigration
{
    // Add the column
	public function up()
	{
        $this->addColumn('{{book}}', 'blurb', 
            'TEXT DEFAULT NULL');
	}

    // Remove the column
	public function down()
	{
		$this->dropColumn('{{book}}', 'blurb');
	}
}