<?php /* @genre */ 
$this->pageTitle = $genre->name;
?>

<h1><span><?php print CHtml::encode($genre->name) ?></span></h1>

<ul class="items">
    <?php foreach ($books as $book): ?>
        <li class="item clear">
            <div class="thumbnail">
                <img src="/<?php print CHtml::encode($book->cover_img) ?>" alt="<?php print CHtml::encode($book->name) ?>">
            </div>
            <div class="description">
                <h3><?php print CHtml::link(CHtml::encode($book->name), array('book/view', 'id' => $book->id)) ?></h3>
            </div>
        </li>
    <?php endforeach; ?>
</ul>