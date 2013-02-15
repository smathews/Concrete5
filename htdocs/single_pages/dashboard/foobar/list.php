<?
defined('C5_EXECUTE') or die(_("Access Denied."));    
echo  Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Awesome'), t('This is awesome.')); ?>
<h1>Hello!</h1>
<p><?=get_class($this->controller)?></p>
<p><?=$this->controller->getTask()?></p>
<p><a href="<?=$this->action('edit')?>">edit</a></p>
<p><a href="<?=$this->action('add')?>">add</a></p>
<p><a href="<?=$this->action('view')?>">view</a></p>
<p>We've just created a new Dashboard page.</p>

