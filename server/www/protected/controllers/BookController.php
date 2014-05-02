<?php

/**
 * Actions associated with book entities.
 *
 * @author Alex Berriman <alex@ajberri.com>
 */

class BookController extends Controller
{
    /**
     * View a particular book
     */
    public function actionView($id)
    {
        // Load the book and make sure it exists
        if (($book = Book::model()->findByPk($id)) === null)
        {
            throw new CHttpException(404, Yii::t('app', 
                'The requested book could not be found.'));
        }
        
        // Render the view
        $this->render('view', [
            'book' => $book,
        ]);
    }
}