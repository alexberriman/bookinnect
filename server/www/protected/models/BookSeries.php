<?php

Yii::import('application.models._base.BaseBookSeries');

class BookSeries extends BaseBookSeries
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}