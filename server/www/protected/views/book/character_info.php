<?php /* @book diagram */ 
$this->pageTitle = $book->name . ' - ' . Yii::app()->name;

// Set ajax layout
$this->layout = 'ajax';
?>

<table class="blue">
    <thead>
        <tr>
            <th>Character name</th>
            <th>Relationship strength</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($character['connections'] as $character): ?>
            <tr>
                <td><?php print CHtml::encode($character) ?></td>
                <td>-</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
