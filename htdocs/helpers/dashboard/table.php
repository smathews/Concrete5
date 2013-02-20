<?php defined('C5_EXECUTE') or die(_("Access Denied."));

//Found this in https://github.com/jordanlev/c5_boilerplate_crud
//  We can use this for now until we want to replace it with something fancier
class DashboardTableHelper {
    
    private $options = array(
        'border' => true
        );
    
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }

    public function getOption($name)
    {
        return @$this->options[$name];
    }

    public function render(&$view, $records, $output_fields, $edit_action = 'edit', $delete_action = 'delete', $sort_action = null, $misc_actions = null) {
            
        $out = array();
        
        $misc_actions = empty($misc_actions) ? array() : $misc_actions;
        
        //open wrappers
        if (!empty($sort_action)) {
            $out[] =  '<div class="sortable-container"'
                   . ' data-sortable-save-url="' . $view->action($sort_action) . '"'
                   . ' data-sortable-save-token="' . Loader::helper('validation/token')->generate() . '"'
                   . '>';
        }

        if(false !== $this->getOption('border'))
        {    
            $out[] = '<table class="table table-striped table-bordered">';
        }
        else
        {
            $out[] = '<table class="table table-striped">';
        }
        
        //headings
        $out[] = '<thead>';
        $out[] = '<tr>';
        //$out[] = empty($edit_action) ? '' : '<th>&nbsp;</th>';
        foreach ($misc_actions as $misc) {
            $out[] = ($misc['placement'] == 'left') ? '<th>&nbsp;</th>' : '';
        }
        foreach ($output_fields as $field => $label) {
            $out[] = "<th>{$label}</th>";
        }
        foreach ($misc_actions as $misc) {
            $out[] = ($misc['placement'] == 'right') ? '<th>&nbsp;</th>' : '';
        }
        $out[] = empty($sort_action) ? '' : '<th>&nbsp;</th>';
        $out[] = (empty($delete_action) && empty($edit_action)) ? '' : '<th>Actions</th>';
        $out[] = '</tr>';
        $out[] = '</thead>';
        
        //rows
        $out[] = '<tbody>';
        foreach ($records as $record) {
            $out[] = empty($sort_action) ? '<tr>' : '<tr data-sortable-id="' . $record->getId() . '">';
            foreach ($misc_actions as $misc) {
                $out[] = ($misc['placement'] == 'left') ? '<td style="padding-left: 0;"><a class="row-button" href="' . $view->action($misc['action'], $record->getId()) . '" title="' . $misc['title'] . '"><i class="' . $misc['icon'] . '"></i></a></td>' : '';
            }
            $last_field = array_pop(array_keys($output_fields));
            foreach ($output_fields as $field => $label) {
                $getter = $record->columnToGetter($field);
                $out[] = ($field === $last_field) ?'<td class="last-field">' : '<td>';
                $out[] = htmlentities($record->$getter());
                $out[] = '</td>';
            }
            foreach ($misc_actions as $misc) {
                $out[] = ($misc['placement'] == 'right') ? '<td><a class="row-button" href="' . $view->action($misc['action'], $record->getId()) . '" title="' . $misc['title'] . '"><i class="' . $misc['icon'] . '"></i></a></td>' : '';
            }
            $out[] = empty($sort_action) ? '' : '<td><span class="row-button sortable-handle" title="drag to sort"><i class="icon-resize-vertical"></i></span></td>';
            $out[] = (empty($delete_action) && empty($edit_action)) ? '' : '<td>';
            $out[] = empty($delete_action) ? '' : '<a class="row-button" href="' . $view->action($delete_action, $record->getId()) . '" title="delete"><i class="icon-trash"></i></a>';
            $out[] = empty($edit_action) ? '' : '<a class="row-button" href="' . $view->action($edit_action, $record->getId()) . '" title="edit"><i class="icon-pencil"></i></a>';
            $out[] = (empty($delete_action) && empty($edit_action)) ? '' : '</td>';
            $out[] = '</tr>';
        }
        $out[] = '</tbody>';
        
        //close wrappers
        $out[] = '</table>';
        $out[] = empty($sort_action) ? '' : '</div><!-- .sortable-container -->';
        
        //output
        $nonempty_lines = array();
        foreach ($out as $line) {
            if (!empty($line)) {
                $nonempty_lines[] = $line;
            }
        }
        echo implode("\n", $nonempty_lines);
    }
    
}
