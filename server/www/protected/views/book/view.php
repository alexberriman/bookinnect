<?php /* @book */ 
$this->pageTitle = $book->name . ' - ' . Yii::app()->name;
$this->breadcrumbs = [
    $book->genre0->name => ['genre/view', 'id' => $book->genre],
    $book->name,    
];

// Register sigma.js files
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/sigmajs/sigma.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/sigmajs/plugins/sigma.parsers.json.min.js');
?>

<h1><span><?php print CHtml::encode($book->name) ?></span></h1>
<?php $this->widget('zii.widgets.CBreadcrumbs', ['links' => $this->breadcrumbs]) ?>

<div class="entry-content clearfix">
    <div class="item-image">
        <img src="/<?php print CHtml::encode($book->getThumbnail(150, 210)) ?>" alt="<?php print CHtml::encode($book->name) ?>"> 
    </div>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Integer leo est, lobortis non egestas eget, interdum vel eros.Curabitur id erat lorem.</p>
    <p>Pellentesque tincidunt pellentesque augue condimentum varius. Suspendisse potenti. Maecenas tristique, purus vel consectetur imperdiet, nunc velit euismod libero, nec sollicitudin metus lectus ac nunc. Cras gravida metus quis ante feugiat rhoncus. Nunc pellentesque massa id tortor porta in sodales dui dictum. Morbi diam justo, malesuada sed lacinia id, ultricies et elit.</p>
</div>

<div class="item-share">
    <div class="social-item fb">
        blah
    </div>
    <div class="social-item">
        blah
    </div>
    <div class="social-item">
        blah
    </div>
</div>

<hr>

<div class="item-info">
    <div class="characters left-icon-col">
        <dt class="title"><h4>Character Entities</h4></dt>
        <table class="blue">
            <thead>
                <tr>
                    <th>Character name</th>
                    <th>Occurrences</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($book->getConnections() as $character): ?>
                    <tr>
                        <td><?php print CHtml::encode($character['name']) ?></td>
                        <td><?php print number_format($character['occurrences']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<hr>

<script type="text/javascript">
  sigma.parsers.json('<?php print Yii::app()->request->baseUrl ?>/book/json/<?php print (int) $book->id ?>', {
    container: 'entity-connections',
    settings: {
      defaultNodeColor: '#308ecf'
    }
  });
</script>

<div class="item-info">
    <div class="characters left-icon-col">
        <dt class="title"><h4>Entity Connections <?php print CHtml::link(Yii::t('app', '(view large)'), ['book/diagram', 'id' => $book->id], ['target' => '_blank']) ?></h4></dt>
        <div id="entity-connections"></div>
    </div>
</div>