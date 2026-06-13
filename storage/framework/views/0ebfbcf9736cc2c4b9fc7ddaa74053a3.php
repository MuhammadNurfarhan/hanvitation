<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-serif text-2xl font-semibold text-red-900 leading-tight">
                <?php echo e(__('Wedding Management')); ?>

            </h2>
            <a href="<?php echo e(route('weddings.create')); ?>" class="inline-flex items-center px-4 py-2 bg-red-900 text-white rounded-xl hover:bg-red-800 transition shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <?php echo e(__('Create New Wedding')); ?>

            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <?php if(session('success')): ?>
            <div x-data="{ show: true }" x-show="show" x-transition
                 class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 flex items-center justify-between">
                <span><?php echo e(session('success')); ?></span>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <?php endif; ?>

            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200">
                    <p class="text-sm text-stone-500 uppercase tracking-wider">Total Weddings</p>
                    <p class="text-3xl font-bold text-red-900 mt-1"><?php echo e($totalWeddings ?? 0); ?></p>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200">
                    <p class="text-sm text-stone-500 uppercase tracking-wider">Published</p>
                    <p class="text-3xl font-bold text-amber-700 mt-1"><?php echo e($publishedWeddings ?? 0); ?></p>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200">
                    <p class="text-sm text-stone-500 uppercase tracking-wider">Total Guests</p>
                    <p class="text-3xl font-bold text-green-700 mt-1"><?php echo e($totalGuests ?? 0); ?></p>
                </div>
            </div>

            
            <div class="bg-white shadow-sm sm:rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-stone-200">
                        <thead class="bg-stone-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Wedding</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Guests</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-stone-200">
                            <?php $__empty_1 = true; $__currentLoopData = $weddings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wedding): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-stone-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php if($wedding->cover_image): ?>
                                        <img src="<?php echo e(asset('storage/' . $wedding->cover_image)); ?>"
                                             class="w-12 h-12 rounded-lg object-cover mr-3" alt="Cover">
                                        <?php else: ?>
                                        <div class="w-12 h-12 bg-stone-200 rounded-lg mr-3 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <?php endif; ?>
                                        <div>
                                            <p class="font-serif font-semibold text-stone-900">
                                                <?php echo e($wedding->groom_first_name); ?> & <?php echo e($wedding->bride_first_name); ?>

                                            </p>
                                            <p class="text-xs text-stone-500"><?php echo e($wedding->slug); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-700">
                                    <?php echo e(\Carbon\Carbon::parse($wedding->event_date)->format('d M Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-700">
                                    <?php echo e($wedding->guests_count ?? 0); ?> guests
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($wedding->is_published): ?>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Published</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-stone-100 text-stone-600">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="<?php echo e(route('weddings.edit', $wedding)); ?>"
                                           class="text-amber-700 hover:text-amber-900" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <a href="<?php echo e($wedding->getInvitationUrlAttribute()); ?>" target="_blank"
                                           class="text-blue-700 hover:text-blue-900" title="Preview">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <form action="<?php echo e(route('weddings.destroy', $wedding)); ?>" method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this wedding? This action cannot be undone.')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-700 hover:text-red-900" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-stone-500">
                                    <svg class="w-16 h-16 mx-auto text-stone-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <p class="text-lg font-medium">No weddings yet</p>
                                    <p class="text-sm mt-1">Create your first wedding invitation to get started.</p>
                                    <a href="<?php echo e(route('weddings.create')); ?>" class="mt-4 inline-flex items-center px-4 py-2 bg-red-900 text-white rounded-xl hover:bg-red-800 transition">
                                        Create Wedding
                                    </a>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                
                <div class="px-6 py-4 border-t border-stone-200">
                    <?php echo e($weddings->links()); ?>

                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\hanvitation\resources\views/admin/weddings/index.blade.php ENDPATH**/ ?>