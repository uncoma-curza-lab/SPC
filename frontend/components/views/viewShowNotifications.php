<!-- <div class="table-responsive">
<table class="table table-striped table-bordered table-hover ">
    <thead class="thead-light">
        <tr>
            <?php 
                /*foreach($columns as $column) {
                    echo '<th scope="col">'.$column.'</th>';
                } */  
            ?>
            
        </tr>
    </thead>
    <tbody>
    <?php
       /* foreach ($models as $model) {
            $count = 0;
            echo "<tr>";
            foreach($columns as $column){
                if($count == 0)
                    echo '<th scope="row">'.$model->$column."</th>";
                else
                    echo "<td>".$model->$column."</td>";
            }
            echo "</tr>";
        }*/
    ?>
    </tbody>
    <tfoot>
        <th>Total</th>
        <td colspan=<?php //echo sizeof($columns); ?>>33</td>
    </tfoot>
    
</table>

</div>
-->

<div class="list-group">
    <?php
        $count = 0;
        foreach ($models as $model) {
            if($count == 0)
                echo '<a href="#" class="list-group-item active">';    
            else
                echo '<a href="#" class="list-group-item ">';
            echo '<p class="list-group-item-heading" >';
            echo $model->getMessage();
            echo '</p>';
            echo '<small>'.$model->getCreatedAt() .'</small>';
            $count++;
            echo "</a>";
        }
    ?>
</div>
<!--
    <tr class="table-active">...</tr>

<tr class="table-primary">...</tr>
<tr class="table-secondary">...</tr>
<tr class="table-success">...</tr>
<tr class="table-danger">...</tr>
<tr class="table-warning">...</tr>
<tr class="table-info">...</tr>
<tr class="table-light">...</tr>
<tr class="table-dark">...</tr>

<div class="panel panel-default">
  <div class="panel-heading">Panel heading without title</div>
  <div class="panel-body">
    Panel content
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Panel title</h3>
  </div>
  <div class="panel-body">
    Panel content
  </div>
</div>
-->