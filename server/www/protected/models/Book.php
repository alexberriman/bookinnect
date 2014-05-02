<?php

Yii::import('application.models._base.BaseBook');

class Book extends BaseBook
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    
    /**
     * Named scopes
     */
    public function scopes()
    {
        return [
            'desc' => [
                'order' => '`id` DESC',
            ],
        ];
    }
    
    /**
     * Fetch books in a certain genre.
     */
    public function genre($genre)
    {
        // If an object passed through, fetch the id
        if (! is_numeric($genre))
        {
            $genre = $genre->id;
        }
        
        // Merge query
        $this->getDbCriteria()->mergeWith([
            'genre' => $genre,
        ]);
    }
}