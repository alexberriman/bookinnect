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
    
    /**
     * View a book character entity diagram.
     */
    public function actionDiagram($id)
    {
        // Load the book and make sure it exists
        if (($book = Book::model()->findByPk($id)) === null)
        {
            throw new CHttpException(404, Yii::t('app', 
                'The requested book could not be found.'));
        }
        
        // Render the view
        $this->render('diagram', [
            'book' => $book,
        ]);
    }
     
    /**
     * View json data
     */
    public function actionJson($id)
    {
        // Load the book and make sure it exists
        if (($book = Book::model()->findByPk($id)) === null)
        {
            throw new CHttpException(404, Yii::t('app', 
                'The requested book could not be found.'));
        }
        
        // Render the view
        $this->renderPartial('json', [
            'book' => $book,
        ]);
    }
    
    /**
     * View character data
     */
    public function actionCharacter($id, $character)
    {
        // Load the book and make sure it exists
        if (($book = Book::model()->findByPk($id)) === null)
        {
            throw new CHttpException(404, Yii::t('app', 
                'The requested book could not be found.'));
        }
        
        // Get the character info
        $characterName = urldecode($character);
        $characters = $book->getConnections();
        
        // Check to make sure the character exists
        if (! isset($characters[$characterName]))
        {
            throw new CHttpException(404, Yii::t('app', 
                'The requested character could not be found.'));
        }
        
        $character = $characters[$characterName];
        
        // Render the view
        $this->render('character_info', [
            'book' => $book,
            'character' => $character,
        ]);
    }
}