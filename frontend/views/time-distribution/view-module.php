<h1> Distribución horaria </h1>
<p>Distribución elegida</p>
<hr>

<div class="row">
    <div class="col-md-10 ">
    <?php foreach($model['time_distribution'] as $distribution): ?>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $distribution['percentage'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $distribution['percentage'] ?>%">
                <p>
                <?= "{$distribution['lesson_type']} - {$distribution['percentage']}% ({$distribution['relative_hours']} hora/s)" ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<p> Total de horas cátedra: <?= $model['total_load_time'] ?></p>
<p> Horas cátedra p/semana: <?= $model['week_load_time'] ?></p>

