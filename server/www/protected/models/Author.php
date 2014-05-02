<?php

Yii::import('application.models._base.BaseAuthor');

class Author extends BaseAuthor
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}