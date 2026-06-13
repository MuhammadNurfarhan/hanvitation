<section id="gallery" class="py-16 sm:py-20 px-6 bg-stone-50 section-fade">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <p class="text-xs uppercase tracking-[0.3em] text-stone-400 mb-2">Moments of Grace</p>
            <h2 class="font-script text-4xl sm:text-5xl text-gradient mb-2">Our Gallery</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
        </div>

        <?php if($wedding->gallery->isNotEmpty()): ?>

        
        <div class="grid grid-cols-2 gap-3 sm:gap-4">
            <?php $__currentLoopData = $wedding->gallery->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $url = $photo->url;
                if (!str_starts_with($url, 'http')) {
                    $url = asset('storage/' . $url);
                }
            ?>

            
            <div class="relative group overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 <?php echo e($index >= 6 ? 'hidden sm:block' : ''); ?>">
                <div class="aspect-square bg-stone-100">
                    <img src="<?php echo e($url); ?>"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         loading="lazy"
                         alt="Gallery <?php echo e($index + 1); ?>">
                </div>

                
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    
                </div>

                
                <?php if($photo->caption): ?>
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <p class="text-white text-xs text-center"><?php echo e(Str::limit($photo->caption, 50)); ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php if($wedding->gallery->count() > 8): ?>
        <div class="text-center mt-6">
            <button onclick="document.getElementById('full-gallery').classList.toggle('hidden')"
                    class="px-6 py-3 bg-gradient-to-r from-red-900 to-red-800 hover:from-red-800 hover:to-red-700 text-white rounded-full font-medium shadow-lg hover:shadow-xl transition-all text-sm">
                Lihat Semua Foto (<?php echo e($wedding->gallery->count()); ?>)
            </button>

            
            <div id="full-gallery" class="hidden mt-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    <?php $__currentLoopData = $wedding->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $url = $photo->url;
                        if (!str_starts_with($url, 'http')) {
                            $url = asset('storage/' . $url);
                        }
                    ?>
                    <div class="relative group overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all">
                        <div class="aspect-square bg-stone-100">
                            <img src="<?php echo e($url); ?>"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                 loading="lazy">
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="text-center py-12 bg-white rounded-2xl shadow-sm">
            <svg class="w-16 h-16 text-stone-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-stone-400">Gallery coming soon</p>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\hanvitation\resources\views/guest/partials/gallery.blade.php ENDPATH**/ ?>