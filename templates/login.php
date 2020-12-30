<h3>Authorisation</h3>

<form method="post" action="<?php echo $this->baseURL ?>admin/login" id="loginForm">
    <?php if ($error = $this->get('error')): ?>
        <div class="alert-error"><?php echo $error ?></div>
    <?php endif ?>
    <div class="form-group">
        <label class="control-label" for="login"><?php echo _('Login') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert your login') ?>" id="login" name="login"
                   type="text"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="password"><?php echo _('Password') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert your password') ?>" id="password"
                   name="password" type="password"/>
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><?php echo _('Enter') ?></button>
</form>
    