<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Добро пожаловать</div>

                <div class="panel-body">
                    Чтобы посмотреть курс валют пожалуйста зарегистрируйтесь. <p>
					<?php if(Session::has('message')): ?>
<?php echo Session::get('message'); ?>

<?php endif; ?>

					
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>