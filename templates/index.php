<?php
$order = $this->get('order');
$orderBy = $this->get('orderBy');
$info = $this->get('info');
?>
<div class="row">
    <div class="span4">
        <?php $this->render('add.php') ?>
    </div>
    <div class="span8">
        <h3>Tasks list</h3>
        <div class="row">

            <?php if ($info): ?>
                <div class="span11 table">
                    <div class="alert-success"><?php echo $info ?></div>
                </div>
            <?php endif ?>
            <table class="span11 table">
                <tr class="table-head">
                    <th><?php echo $this->sortLink('name', _('Name')) ?></th>
                    <th><?php echo $this->sortLink('email', _('Email')) ?></th>
                    <th><?php echo $this->sortLink('description', _('Task')) ?></th>
                    <th class="status-td"><?php echo $this->sortLink('status', _('Done')) ?></th>
                </tr>
                <?php foreach ($this->get('tasks') as $task): ?>
                    <tr>
                        <td><?php echo $task->name ?></td>
                        <td><?php echo $task->email ?></td>
                        <td <?php if ($auth->isAuth()): ?> class="editable" data-id="<?php echo $task->id ?>"<?php endif ?>>
                            <?php echo $this->getDescription($task) ?>
                        </td>
                        <td class="text-center check-done">
                            <?php if ($task->status): ?>
                                &check;
                            <?php elseif ($auth->isAuth()): ?>
                                <a href="<?php echo $this->baseURL ?>done?id=<?php echo $task->id ?>"
                                   class="btn btn-success">&check;</a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="span11">
                <?php for ($p = 1; $p <= $this->get('pages'); $p++): ?>
                    <a class="btn btn-info <?php echo $p == $this->get('page') ? 'active' : '' ?>"
                       href="?page=<?php echo $p ?>&order=<?php echo $order ?>&orderBy=<?php echo $orderBy ?>"
                    ><?php echo $p ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>