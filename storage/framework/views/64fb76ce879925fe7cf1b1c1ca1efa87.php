

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary">
            ← Voltar ao Dashboard
        </a>
        <?php if(auth()->user()->isAdmin()): ?>
            <a href="<?php echo e(route('doctors.create')); ?>" class="btn btn-primary">
                <i class="fas fa-user-md"></i> Cadastrar Médico
            </a>
        <?php endif; ?>
    </div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Médicos</h1>
    </div>
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CRM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especialidade</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900"><?php echo e($doctor->user->name); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?php echo e($doctor->user->email); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?php echo e($doctor->crm); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?php echo e($doctor->specialty); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="<?php echo e(route('doctors.show', $doctor)); ?>" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                        <form action="<?php echo e(route('doctors.destroy', $doctor)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\webll\resources\views/doctors/index.blade.php ENDPATH**/ ?>