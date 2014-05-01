<?php

/**
  * Initial database structure for bookinnect website
  *
  * @author Alex Berriman <alex@ajberri.com>
  */

class m140501_081143_initital_db_schema extends CDbMigration
{
    /**
     * Migrate up! Create the tables/initial db schema.
     */
	public function up()
	{
        // Genre table
        $this->createTable('{{genre}}', [
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'parent_id' => 'int DEFAULT NULL',
        ]);
        $this->addForeignKey('genre_parent_id_fk', '{{genre}}', 'parent_id',
            '{{genre}}', 'id', 'CASCADE', 'CASCADE');
            
        // Author table
        $this->createTable('{{author}}', [
            'id' => 'pk',
            'name' => 'string NOT NULL',
        ]);
        
        // Series table
        $this->createTable('{{series}}', [
            'id' => 'pk',
            'name' => 'string NOT NULL',
        ]);
        
        // Book table
        $this->createTable('{{book}}', [
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'author' => 'int DEFAULT 0',
            'word_count' => 'int DEFAULT 0',
            'date_published' => 'date',
            'genre' => 'int DEFAULT NULL',
            'cover_img' => 'string DEFAULT NULL',
        ]);
        $this->addForeignKey('book_author_fk', '{{book}}', 'author', 
            '{{author}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('book_genre_fk', '{{book}}', 'genre', '{{genre}}',
            'id', 'CASCADE', 'CASCADE');
        
        // Book series table
        $this->createTable('{{book_series}}', [
            'book_id' => 'int NOT NULL',
            'series_id' => 'int NOT NULL',
            'sequence_number' => 'int DEFAULT 0',
            'PRIMARY KEY (`book_id`, `series_id`)',
        ]);
        $this->addForeignKey('book_series_book_id_fk', '{{book_series}}', 
            'book_id', '{{book}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('book_series_series_id_fk', '{{book_series}}',
            'series_id', '{{series}}', 'id', 'CASCADE', 'CASCADE');
	}

    /**
     * Drop the tables and migrate back down.
     */
	public function down()
	{
		$this->dropTable('{{book_series}}');
        $this->dropTable('{{book}}');
        $this->dropTable('{{series}}');
        $this->dropTable('{{author}}');
        $this->dropTable('{{genre}}');
	}
}