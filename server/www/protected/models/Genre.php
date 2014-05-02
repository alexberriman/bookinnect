<?php

Yii::import('application.models._base.BaseGenre');

class Genre extends BaseGenre
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
            'root' => [
                'condition' => 'parent_id IS NULL OR parent_id = 0',
            ],
            'alphabetical' => [
                'order' => 'lower(name) ASC',
            ],
        ];
    }
    
    /**
     * Select with parent
     */
    public function parent($parentId)
    {
        $this->getDbCriteria()->mergeWith([
            'parent_id' => $parentId,
        ]);
    }
}