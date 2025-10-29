<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Médico</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Sistema de Consultas Médicas
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Faça login para acessar o sistema
                </p>
            </div>
            <form class="mt-8 space-y-6" action="<?php echo e(route('login')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Email" value="<?php echo e(old('email')); ?>">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Senha</label>
                        <input id="password" name="password" type="password" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                               placeholder="Senha">
                    </div>
                </div>

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-red-500 text-sm"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Entrar
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="<?php echo e(route('register')); ?>" class="text-blue-600 hover:text-blue-800">Não tem uma conta? Cadastre-se</a>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Credenciais de Teste:</h3>
                <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
                    <div><strong>Admin:</strong> admin@clinica.com / password</div>
                    <div><strong>Médico:</strong> joao.silva@clinica.com / password</div>
                    <div><strong>Paciente:</strong> carlos@email.com / password</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\projeto-web-2-teste-ssh\resources\views/auth/login.blade.php ENDPATH**/ ?>