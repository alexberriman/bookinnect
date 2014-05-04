<?php /* @book diagram */ 

// Page title and breadcrumbs
$this->pageTitle = $book->name . ' - ' . Yii::app()->name;
$this->breadcrumbs = [
    $book->genre0->name => ['genre/view', 'id' => $book->genre],
    $book->name => ['book/view', 'id' => $book->id],
    $character['name']
];

// Register sigma.js files
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/sigmajs/sigma.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/sigmajs/plugins/sigma.parsers.json.min.js');
?>

<h1><span><?php print CHtml::encode($character['name']) ?></span></h1>
<?php $this->widget('zii.widgets.CBreadcrumbs', ['links' => $this->breadcrumbs]) ?>

<div class="item-info" style="padding-top: 15px;">
    <div class="characters left-icon-col">
        <dt class="title"><h4>Character Relationships</h4></dt>
    </div>
</div>
<table class="blue" style="margin-top: -10px;">
    <thead>
        <tr>
            <th width="50%">Character name</th>
            <th width="50%">Relationship strength</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($character['connections'] as $char): ?>
            <tr>
                <td><?php print CHtml::link(CHtml::encode($char['name']), ['book/character', 'id' => $book->id, 'character' => urlencode(CHtml::encode($char['name']))], ['class' => 'popup']) ?></td>
                <td><?php echo TbHtml::progressBar(round($char['strength'] * 100, 2)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr>

<script type="text/javascript">
  sigma.parsers.json('<?php print Yii::app()->request->baseUrl ?>/book/json/id/<?php print (int) $book->id ?>/character/<?php print urlencode(CHtml::encode($character['name'])) ?>', {
    container: 'entity-connections',
    settings: {
      defaultNodeColor: '#308ecf',
      defaultEdgeColor: '#999',
      edgeColor: 'default',
      defaultNodeBorderColor: '#fff',
      borderSize: 2,
      labelHoverShadowColor: '#fff',
      defaultHoverLabelBGColor: '#eee',
      minNodeSize: 4,
      maxNodeSize: 12
    }
  });
</script>

<div class="item-info" style="padding-top: 15px;">
    <div class="characters left-icon-col">
        <dt class="title"><h4>Relationship Graph</h4></dt>
    </div>
</div>

<div id="entity-connections"></div>