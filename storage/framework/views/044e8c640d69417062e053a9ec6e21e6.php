<section id="events" class="py-16 sm:py-20 px-6 bg-white section-fade">
    <div class="max-w-lg mx-auto">
        <div class="text-center mb-10">
            <p class="text-xs uppercase tracking-[0.3em] text-stone-400 mb-2">Save The Date</p>
            <h2 class="font-script text-4xl sm:text-5xl text-gradient mb-2">Wedding Events</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
        </div>

        
        <?php $__empty_1 = true; $__currentLoopData = $wedding->events->sortBy('order'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="rounded-2xl p-6 shadow-lg mb-6 border transition-all hover:shadow-xl
            <?php echo e($event->type === 'misa' ? 'bg-gradient-to-br from-red-50 to-stone-50 border-red-100' :
                ($event->type === 'resepsi' ? 'bg-gradient-to-br from-amber-50 to-stone-50 border-amber-100' :
                ($event->type === 'akad' ? 'bg-gradient-to-br from-pink-50 to-stone-50 border-pink-100' :
                'bg-gradient-to-br from-green-50 to-stone-50 border-green-100'))); ?>">

            <div class="flex items-center gap-4 mb-4">
                
                <div class="w-14 h-14 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg bg-<?php echo e($event->type_color); ?>-700">
                    <?php echo $event->type_icon; ?>

                </div>

                <div>
                    
                    <h3 class="font-serif-custom text-xl font-bold text-red-900">
                        <?php echo e($event->type_label); ?>

                    </h3>
                    <p class="text-xs text-stone-500 uppercase tracking-wider">
                        <?php echo e($event->type === 'misa' ? 'Sacrament of Holy Matrimony' :
                            ($event->type === 'resepsi' ? 'Wedding Reception' :
                            ($event->type === 'akad' ? 'Marriage Covenant' :
                            'Welcome Reception'))); ?>

                    </p>
                </div>
            </div>

            <div class="space-y-3 mb-5 ml-4">
                
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-stone-800 text-sm">
                            <?php echo e(\Carbon\Carbon::parse($event->start_time)->isoFormat('dddd, D MMMM YYYY')); ?>

                        </p>
                        <p class="text-xs text-stone-500">
                            <?php echo e(\Carbon\Carbon::parse($event->start_time)->format('H:i')); ?> WIB
                            <?php if($event->end_time): ?>
                                - <?php echo e(\Carbon\Carbon::parse($event->end_time)->format('H:i')); ?>

                            <?php else: ?>
                                - Selesai
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-stone-800 text-sm"><?php echo e($event->venue_name); ?></p>
                        <p class="text-xs text-stone-500"><?php echo e($event->address); ?></p>
                    </div>
                </div>

                
                <?php if($event->description): ?>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-stone-800 text-sm">
                            <?php echo e($event->description); ?>

                        </p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            
            <?php if($event->maps_link): ?>
            <a href="<?php echo e($event->maps_link); ?>" target="_blank"
               class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-medium transition-colors text-sm
               <?php echo e($event->type === 'misa' ? 'bg-red-900 hover:bg-red-800 text-white' :
                   ($event->type === 'resepsi' ? 'bg-amber-700 hover:bg-amber-800 text-white' :
                   ($event->type === 'akad' ? 'bg-pink-700 hover:bg-pink-800 text-white' :
                   'bg-green-700 hover:bg-green-800 text-white'))); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                Google Maps
            </a>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        
        <div class="text-center py-12 bg-stone-50 rounded-2xl border border-stone-200">
            <svg class="w-16 h-16 text-stone-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-stone-500">Detail acara akan segera diumumkan.</p>
        </div>
        <?php endif; ?>

        
        <button @click="addToCalendar()"
                class="mt-6 w-full border-2 border-stone-300 hover:border-red-900 text-stone-600 hover:text-red-900 py-3 rounded-xl font-medium transition-all flex items-center justify-center gap-2 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Simpan ke Kalender
        </button>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\hanvitation\resources\views/guest/partials/events.blade.php ENDPATH**/ ?>