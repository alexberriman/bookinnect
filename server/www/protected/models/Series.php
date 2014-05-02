<?php

Yii::import('application.models._base.BaseSeries');

class Series extends BaseSeries
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}