<?
defined('C5_EXECUTE') or die(_("Access Denied."));    

$th = Loader::helper('dashboard/table');
$dh = Loader::helper('concrete/dashboard');
$ih = Loader::helper('concrete/interface');
$fh = Loader::helper('form');

$action = $this->controller->getTask();

echo $dh->getDashboardPaneHeaderWrapper(t('Prefered Cities'), t('Geo Mapping for Prefered Cities')); 

//any list view, or returning to list
if(in_array($action, array('view','save','delete')))
{
    //primary is class
    ?>
    <div style="margin-bottom:10px;float:right">
        <?=$ih->button("Add New", $this->action('add'), true, 'primary')?>
    </div>
    <?

    //example option, not needed
    $th->setOption('border',true);
    
    $th->render($this,$preferCities, array('name' => 'Name', 'latitude' => 'Latitude', 'longitude' => 'Longitude'));
}
else
{
    //edit or add
    ?>
    <form method="post" class="form-horizontal" action="<?=$this->action('save')?>">
        <?=$token?>
        <?=$fh->hidden('id', $id)?>

        <fieldset>
            <div class="control-group">
                <?=$fh->label('name', 'Name:')?>
                <div class="controls">
                    <?=$fh->text('fields[name]', $preferCity->getName(), array('maxlength' => '255'))?></td>
                </div>
            </div>
            <div class="control-group">
                <?=$fh->label('latitude', 'Latitude:')?>
                <div class="controls">
                    <?=$fh->text('fields[latitude]', $preferCity->getLatitude(), array('maxlength' => '255'))?></td>
                </div>
            </div>
            <div class="control-group">
                <?=$fh->label('longitude', 'Longitude:')?>
                <div class="controls">
                    <?=$fh->text('fields[longitude]', $preferCity->getLongitude(), array('maxlength' => '255'))?></td>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?=$ih->submit('Save', false, false, 'primary')?>
                </div>
            </div>
        </fieldset> 

    </form>
    <?
}

echo $dh->getDashboardPaneFooterWrapper();
