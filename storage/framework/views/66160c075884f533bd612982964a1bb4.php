

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Cadastrar Médico</h1>
    <?php if($errors->any()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('doctors.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label class="block text-gray-700">Nome</label>
            <input type="text" name="name" class="border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">E-mail</label>
            <input type="email" name="email" class="border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Senha</label>
            <input type="password" name="password" class="border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Confirme a Senha</label>
            <input type="password" name="password_confirmation" class="border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">CRM</label>
            <input type="text" name="crm" class="border rounded w-full py-2 px-3" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Especialidade</label>
            <input type="text" name="specialty" class="border rounded w-full py-2 px-3" required>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
    </form>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\webll\resources\views/doctors/create.blade.php ENDPATH**/ ?>