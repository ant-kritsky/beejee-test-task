<h3><?php echo _('Add task') ?></h3>
<form method="post" id="addTask" action="<?php echo $this->baseURL ?>add">
    <?php $errors = $this->get('errors') ?>
    <div class="form-group">
        <label class="control-label" for="name"><?php echo _('Name') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert name') ?>"
                   value="<?php echo $this->get('name') ?>" id="name" name="name" type="text"/>
            <?php if (!empty($errors['name'])): ?>
                <div class="alert-error"><?php echo $errors['name'] ?></div>
            <?php endif ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="email"><?php echo _('Email') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert email') ?>"
                   value="<?php echo $this->get('email') ?>" id="email" name="email" type="text"/>
            <?php if (!empty($errors['email'])): ?>
                <div class="alert-error"><?php echo $errors['email'] ?></div>
            <?php endif ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="description"><?php echo _('Test') ?>:</label>

        <div class="input-group">
            <textarea class="form-control" placeholder="<?php echo _('Insert task text') ?>" id="description"
                      name="description"><?php echo $this->get('description') ?></textarea>
            <?php if (!empty($errors['description'])): ?>
                <div class="alert-error"><?php echo $errors['description'] ?></div>
            <?php endif ?>
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><?php echo _('Add') ?></button>
</form>
    