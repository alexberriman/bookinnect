<?php /* @genre */ 
$this->pageTitle = $genre->name . ' - ' . Yii::app()->name;
$this->breadcrumbs = [
	CHtml::encode($genre->name),
];
?>

<h1><span><?php print CHtml::encode($genre->name) ?></span></h1>
<?php $this->widget('zii.widgets.CBreadcrumbs', ['links' => $this->breadcrumbs]) ?>

<ul class="items">
    <?php foreach ($books as $book): ?>
        <li class="item clear">
            <div class="thumbnail">
                <img src="/<?php print CHtml::encode($book->getThumbnail(130, 160)) ?>" alt="<?php print CHtml::encode($book->name) ?>">
            </div>
            <div class="description">
                <h3><?php print CHtml::link(CHtml::encode($book->name), array('book/view', 'id' => $book->id)) ?></h3>
                <p>
                    <strong>Author:</strong> <?php print CHtml::link(CHtml::encode($book->author0->name), array('author/view', 'id' => $book->author)) ?> <br>
                    <strong>Published:</strong> <?php print date('d/m/Y', strtotime($book->date_published)) ?> <br>
                    <strong>Word count:</strong> <?php print number_format($book->word_count) ?> <br>
                </p>
            </div>
        </li>
    <?php endforeach; ?>
</ul>