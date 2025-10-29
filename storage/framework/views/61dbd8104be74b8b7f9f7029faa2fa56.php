

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-end mb-3">
        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary">
            ← Voltar ao Dashboard
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Consultas</h4>
                    <?php if(auth()->user()->role === 'paciente'): ?>
                        <a href="<?php echo e(route('appointments.available')); ?>" class="btn btn-success">
                            <i class="fas fa-calendar-check"></i> Ver Horários Disponíveis
                        </a>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <?php if($appointments->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Paciente</th>
                                        <th>Médico</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($appointment->patient->user->name); ?></td>
                                        <td>
                                            <?php echo e($appointment->doctor->user->name); ?>

                                            <br><small class="text-muted"><?php echo e($appointment->doctor->specialty); ?></small>
                                        </td>
                                        <td><?php echo e(\Carbon\Carbon::parse($appointment->date)->format('d/m/Y')); ?></td>
                                        <td><?php echo e($appointment->time); ?></td>
                                        <td>
                                            <?php if($appointment->status === 'pendente'): ?>
                                                <span class="badge bg-warning">Pendente</span>
                                            <?php elseif($appointment->status === 'confirmada'): ?>
                                                <span class="badge bg-success">Confirmada</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Cancelada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('appointments.show', $appointment)); ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            
                                            <?php if($appointment->status === 'pendente'): ?>
                                                <?php if(auth()->user()->role === 'medico' && auth()->user()->doctor->id === $appointment->doctor_id): ?>
                                                    <form action="<?php echo e(route('appointments.confirm', $appointment)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i> Confirmar
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            
                                            <?php if($appointment->status !== 'cancelada'): ?>
                                                <form action="<?php echo e(route('appointments.cancel', $appointment)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">
                                                        <i class="fas fa-times"></i> Cancelar
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            
                                            <?php if($appointment->status === 'confirmada'): ?>
                                                <a href="<?php echo e(route('certificates.generate', $appointment)); ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-pdf"></i> PDF
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Nenhuma consulta encontrada.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\webll\resources\views/appointments/index.blade.php ENDPATH**/ ?>