<?php /* @book diagram */ 
$this->pageTitle = $book->name . ' - ' . Yii::app()->name;

// Register sigma.js files
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/sigmajs/sigma.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/sigmajs/plugins/sigma.parsers.json.min.js');

// Set fullscreen layout
$this->layout = 'fullscreen';
?>

<script type="text/javascript">
  sigma.parsers.json('<?php print Yii::app()->request->baseUrl ?>/book/json/<?php print (int) $book->id ?>', {
    container: 'entity-connections-large',
    settings: {
      defaultNodeColor: '#308ecf',
      defaultNodeHoverColor: '#000',
      defaultEdgeColor: '#999',
      defaultNodeBorderColor: '#fff',
      labelHoverShadowColor: '#fff',
      defaultHoverLabelBGColor: '#eee',
      edgeColor: 'source',
      borderSize: 2,
      minNodeSize: 4,
      maxNodeSize: 18
    }
  });
</script>

<div id="entity-connections-large"></div>