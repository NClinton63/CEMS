<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->featured_image): ?>
            <div class="relative h-96 bg-gray-900">
                <img src="<?php echo e(asset('storage/' . $event->featured_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-full object-cover opacity-90">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <div class="max-w-7xl mx-auto">
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-primary-500 text-white mb-3">
                            <?php echo e($event->category); ?>

                        </span>
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-2"><?php echo e($event->title); ?></h1>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->status === 'cancelled'): ?>
                            <span class="inline-block px-4 py-2 bg-danger text-white rounded-full text-sm font-semibold">
                                Cancelled
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="relative h-64 bg-gradient-to-br from-primary-500 to-primary-700">
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-24 h-24 text-white opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <div class="max-w-7xl mx-auto">
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-white/20 text-white mb-3">
                            <?php echo e($event->category); ?>

                        </span>
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-2"><?php echo e($event->title); ?></h1>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->status === 'cancelled'): ?>
                            <span class="inline-block px-4 py-2 bg-danger text-white rounded-full text-sm font-semibold">
                                Cancelled
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="card p-8 mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Event</h2>
                        <p class="text-gray-700 leading-relaxed text-lg"><?php echo e($event->description); ?></p>
                    </div>

                    <div class="card p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Organizer</h2>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-lg"><?php echo e(substr($event->organizer->name, 0, 1)); ?></span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900"><?php echo e($event->organizer->name); ?></p>
                                <p class="text-sm text-gray-600"><?php echo e($event->organizer->email); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="card p-6 sticky top-20">

                        <h3 class="text-lg font-bold text-gray-900 mb-4">Event Details</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Date</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($event->start_time->format('l, F d, Y')); ?></p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Time</p>
                                    <p class="font-semibold text-gray-900">
                                        <?php echo e($event->start_time->format('g:i A')); ?> - <?php echo e($event->end_time->format('g:i A')); ?>

                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Location</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($event->location); ?></p>
                                    <p class="text-xs text-gray-500 mt-1"><?php echo e(ucfirst($event->location_type)); ?></p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Capacity</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($event->availableSpots()); ?> / <?php echo e($event->capacity); ?> spots</p>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                        <div class="bg-primary-600 h-2 rounded-full" style="width: <?php echo e(($event->capacity - $event->availableSpots()) / $event->capacity * 100); ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->status === 'published' && !$event->isPast()): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userRegistration): ?>
                                    <div class="bg-green-50 border-l-4 border-success rounded-lg p-4 mb-4">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-success mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <div>
                                                <p class="text-green-800 font-semibold">You're registered!</p>
                                                <p class="text-sm text-green-700 mt-1">Registered on <?php echo e($userRegistration->created_at->format('M d, Y')); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <button wire:click="cancelRegistration" 
                                        class="w-full px-6 py-3 bg-white border-2 border-danger text-danger rounded-lg hover:bg-danger hover:text-white font-medium transition-colors">
                                        Cancel Registration
                                    </button>
                                <?php else: ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->isFull()): ?>
                                        <div class="bg-yellow-50 border-l-4 border-warning rounded-lg p-4">
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-warning mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                <p class="text-yellow-800 font-medium">This event is currently full</p>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <button wire:click="register" 
                                            class="w-full btn-primary text-center">
                                            Register for Event
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php elseif($event->isPast()): ?>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <p class="text-gray-600 text-center">This event has ended</p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <div class="text-center">
                                <p class="text-gray-600 mb-4">Sign in to register</p>
                                <a href="/login" class="btn-primary inline-block">
                                    Sign In
                                </a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <a href="/" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Events
                </a>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH /Users/clintonngwa/Documents/github/CEMS/resources/views/livewire/event-details.blade.php ENDPATH**/ ?>