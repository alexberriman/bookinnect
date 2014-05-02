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
    
    /**
     * Reads the standard thumbnail in the database, converts it to a different
     * size and returns the path.
     *
     * @param $width
     *  The width the thumbnail should be resized to.
     * @param $height
     *  The height the thumbnail should be resized to.
     * @return
     *  The URI to the resized thumbnail.
     */
    public function getThumbnail($width=112, $height=140)
    {
        // Fetch the path to the thumbfile
        $thumbFile = Yii::app()->basePath . '/../' . $this->cover_img;
        if (file_exists($thumbFile))
        {
            // Fetch the file name and extension
            $parts = explode('/', $this->cover_img);
            $name = end($parts);
            list($fileName, $extension) = explode('.', $name);
            
            // Target file name
            $targetFileName = $fileName . '-' . $width . 'x' . $height;
            $targetFile = str_replace($fileName, $targetFileName, 
                $thumbFile);
            
            // If the target file doesn't exist, create it
            if (! file_exists($targetFile))
            {
                Yii::import('application.vendor.wideimage.*');
                WideImage::load($thumbFile)->resize($width, $height)->
                    saveToFile($targetFile);
            }
            
            // Return the updated file
            return str_replace($name, $targetFileName . '.' . $extension,
                $this->cover_img);
        }
        
        return '';
    }
    
    /**
     * Returns the connections mined from the book.
     */
    public function getConnections()
    {
        // If no valid xml, return nothing
        if ($this->connections_xml === null || $this->connections_xml === '')
        {
            return [];
        }
        
        // Load the xml and process
        $xml = simplexml_load_string($this->connections_xml);
        var_dump($xml);
    }
}