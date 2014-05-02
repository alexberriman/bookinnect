<?php

class GenreController extends Controller
{
    /**
     * Show all books from a particular genre
     */
    public function actionView($id)
    {
        // Select genre and make sure it exists
        if (($genre = Genre::model()->findByPk($id)) === null)
        {
            throw new CHttpException(404, Yii::t('app', 
                'The selected genre could not be found.'));
        }
        
        // Fetch the books
        $books = Book::model()->desc()->findAll();
        
        // Render the view
        $this->render('view', [
            'genre' => $genre,
            'books' => $books,
        ]);
    }
}