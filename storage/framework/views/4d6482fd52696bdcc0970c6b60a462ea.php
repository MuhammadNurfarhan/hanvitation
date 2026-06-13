<section id="quote" class="py-16 sm:py-20 px-6 bg-white section-fade">
    <div class="max-w-lg mx-auto text-center">
        
        <div class="flex justify-center mb-6">
            <svg class="w-10 h-10 text-amber-500/50" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
        </div>

        <blockquote class="font-serif-custom text-lg sm:text-xl text-stone-700 italic leading-relaxed mb-4">
            <?php if($wedding->quote): ?>
                "<?php echo e($wedding->quote); ?>"
            <?php else: ?>
                "Sebab itu laki-laki akan meninggalkan ayah dan ibunya dan bersatu dengan istrinya, sehingga keduanya menjadi satu daging."
            <?php endif; ?>
        </blockquote>

        <cite class="text-sm text-amber-700 font-medium not-italic">
            — <?php echo e($wedding->quote_source ?? 'Kejadian 2:24'); ?>

        </cite>

        <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto mt-6"></div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\hanvitation\resources\views/guest/partials/quote.blade.php ENDPATH**/ ?>