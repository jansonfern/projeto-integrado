

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Detalhes do Médico</h4>
                    <div>
                        <a href="<?php echo e(route('doctors.index')); ?>" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informações Pessoais</h5>
                            <p><strong>Nome:</strong> <?php echo e($doctor->user->name); ?></p>
                            <p><strong>Email:</strong> <?php echo e($doctor->user->email); ?></p>
                            <p><strong>CRM:</strong> <?php echo e($doctor->crm); ?></p>
                            <p><strong>Especialidade:</strong> <?php echo e($doctor->specialty); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Estatísticas</h5>
                            <p><strong>Total de Consultas:</strong> <?php echo e($doctor->appointments->count()); ?></p>
                            <p><strong>Horários Disponíveis:</strong> <?php echo e($doctor->schedules->where('is_available', true)->count()); ?></p>
                        </div>
                    </div>
                    
                    <?php if($doctor->appointments->count() > 0): ?>
                        <div class="mt-4">
                            <h5>Últimas Consultas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Horário</th>
                                            <th>Paciente</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $doctor->appointments->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(\Carbon\Carbon::parse($appointment->date)->format('d/m/Y')); ?></td>
                                                <td><?php echo e($appointment->time); ?></td>
                                                <td><?php echo e($appointment->patient->user->name); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo e($appointment->status === 'confirmada' ? 'success' : ($appointment->status === 'cancelada' ? 'danger' : 'warning')); ?>">
                                                        <?php echo e(ucfirst($appointment->status)); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\webll\resources\views/doctors/show.blade.php ENDPATH**/ ?>