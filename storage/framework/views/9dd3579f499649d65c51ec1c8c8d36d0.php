<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
  
  <?php if(session('success')): ?>
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <?php if($errors->any()): ?>
    <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4">
      <?php echo e($errors->first()); ?>

    </div>
  <?php endif; ?>

  <div class="max-w-5xl mx-auto py-8 grid grid-cols-1 md:grid-cols-2 gap-8">
    
    <div>
      <img src="<?php echo e(profile_image($product->image_path)); ?>"
           alt="<?php echo e($product->name); ?>"
           class="w-full h-96 object-cover rounded-lg border dark:border-gray-700">
    </div>

    
    <div>
      
      <div class="flex items-start justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($product->name); ?></h1>
          <div class="flex gap-3">
            <p class="text-gray-500 dark:text-gray-400 mt-1"><?php echo e($product->category->name ?? 'Uncategorized'); ?></p>
            <div class="text-gray-500 dark:text-gray-400 mt-1">|</div>
            <div class="text-gray-500 dark:text-gray-400 mt-1"><?php echo e($product->stock); ?> in stock</div>
          </div>
        </div>

        
        <form action="<?php echo e(route('shop.wishlist.toggle', $product)); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <?php
            $isWished = Auth::check() && Auth::user()->customer
              ? Auth::user()->customer->wishlists()->where('product_id', $product->id)->exists()
              : false;
          ?>
          <button type="submit" title="Add to Wishlist">
            <?php if($isWished): ?>
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                   class="w-7 h-7 text-red-500 hover:text-red-600" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5a5.5 5.5 0 0111 0 5.5 5.5 0 0111 0c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
            <?php else: ?>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                   class="w-7 h-7 text-gray-400 hover:text-red-500" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a5.5 5.5 0 017.778 0L12 6.939l-.096-.096a5.5 5.5 0 117.778 7.778L12 21l-7.682-7.379a5.5 5.5 0 010-7.303z"/>
              </svg>
            <?php endif; ?>
          </button>
        </form>
      </div>

      
      <p class="text-2xl text-blue-600 font-semibold mt-4">
        Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

      </p>

      
      <p class="mt-6 text-gray-700 dark:text-gray-300 leading-relaxed">
        <?php echo $product->description ?? 'No description available for this product.'; ?>

      </p>

      
      <div class="mt-8 flex gap-3">
        <form action="<?php echo e(route('shop.cart.add', $product)); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <button class="px-5 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">Add to Cart</button>
        </form>

        <form action="<?php echo e(route('shop.cart.buyNow', $product)); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <button class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Buy Now</button>
        </form>
      </div>

      <hr class="my-10 border-gray-300 dark:border-gray-700">

      
      <div class="mt-6 space-y-6" x-data="{ filter: 0 }">
        
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          Customer Reviews
          <span class="text-sm text-gray-500">(<?php echo e($product->reviews->count()); ?>)</span>
        </h2>

        
        <?php $avg = round($product->average_rating, 1); ?>
        <div class="flex items-center gap-2">
          <div class="flex">
            <?php for($i = 1; $i <= 5; $i++): ?>
              <svg xmlns="http://www.w3.org/2000/svg" 
                   fill="<?php echo e($i <= $avg ? 'currentColor' : 'none'); ?>"
                   class="w-5 h-5 <?php echo e($i <= $avg ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'); ?>"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 
                         0l1.286 3.948a1 1 0 00.95.69h4.148c.969 
                         0 1.371 1.24.588 1.81l-3.36 
                         2.44a1 1 0 00-.364 1.118l1.286 
                         3.948c.3.921-.755 1.688-1.54 
                         1.118l-3.36-2.44a1 1 0 00-1.176 
                         0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                         1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                         1 0 00.95-.69l1.286-3.948z"/>
              </svg>
            <?php endfor; ?>
          </div>
          <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($avg); ?>/5</span>
        </div>

        
        <?php if(auth()->guard()->check()): ?>
          <?php if(auth()->user()->customer): ?>
            <form action="<?php echo e(route('shop.reviews.store', $product)); ?>" method="POST" class="mt-4 space-y-3" x-data="{ rating: 0 }">
              <?php echo csrf_field(); ?>
              <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600 dark:text-gray-300">Your Rating:</label>
                <div class="flex items-center gap-1">
                  <?php for($i = 1; $i <= 5; $i++): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" class="w-7 h-7 cursor-pointer transition"
                         :class="rating >= <?php echo e($i); ?> ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                         @click="rating = <?php echo e($i); ?>">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 
                               0l1.286 3.948a1 1 0 00.95.69h4.148c.969 
                               0 1.371 1.24.588 1.81l-3.36 
                               2.44a1 1 0 00-.364 1.118l1.286 
                               3.948c.3.921-.755 1.688-1.54 
                               1.118l-3.36-2.44a1 1 0 00-1.176 
                               0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                               1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                               1 0 00.95-.69l1.286-3.948z"/>
                    </svg>
                  <?php endfor; ?>
                </div>
                <input type="hidden" name="rating" x-model="rating">
              </div>

              <textarea name="comment" rows="3" placeholder="Write your review..."
                        class="w-full border rounded-lg p-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"></textarea>

              <button type="submit"
                      class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm disabled:opacity-50"
                      :disabled="rating === 0">
                Submit Review
              </button>
            </form>
          <?php endif; ?>
        <?php endif; ?>

        
        <?php
          $totalReviews = $product->reviews->count();
          $ratings = [];
          for ($i = 5; $i >= 1; $i--) {
              $ratings[$i] = $product->reviews()->where('rating', $i)->count();
          }
        ?>

        <?php if($totalReviews > 0): ?>
          <div class="mt-6 border border-gray-200 dark:border-gray-800 rounded-lg p-4 bg-gray-50 dark:bg-gray-800/50">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="text-4xl font-bold text-yellow-400"><?php echo e(number_format($avg, 1)); ?></span>
                <div class="flex flex-col">
                  <div class="flex">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                      <svg xmlns="http://www.w3.org/2000/svg" 
                           fill="<?php echo e($i <= $avg ? 'currentColor' : 'none'); ?>"
                           class="w-5 h-5 <?php echo e($i <= $avg ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'); ?>"
                           viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 
                                 0l1.286 3.948a1 1 0 00.95.69h4.148c.969 
                                 0 1.371 1.24.588 1.81l-3.36 
                                 2.44a1 1 0 00-.364 1.118l1.286 
                                 3.948c.3.921-.755 1.688-1.54 
                                 1.118l-3.36-2.44a1 1 0 00-1.176 
                                 0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                                 1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                                 1 0 00.95-.69l1.286-3.948z"/>
                      </svg>
                    <?php endfor; ?>
                  </div>
                  <p class="text-sm text-gray-500"><?php echo e($totalReviews); ?> Reviews</p>
                </div>
              </div>
            </div>

            
            <div class="mt-4 space-y-1">
              <?php $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $star => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $percent = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0; ?>
                <div class="flex items-center gap-3">
                  <button type="button"
                          class="flex items-center gap-1 text-sm text-gray-700 dark:text-gray-300"
                          @click="filter = <?php echo e($star); ?>">
                    <span><?php echo e($star); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 
                               3.948a1 1 0 00.95.69h4.148c.969 
                               0 1.371 1.24.588 1.81l-3.36 
                               2.44a1 1 0 00-.364 1.118l1.286 
                               3.948c.3.921-.755 1.688-1.54 
                               1.118l-3.36-2.44a1 1 0 00-1.176 
                               0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                               1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                               1 0 00.95-.69l1.286-3.948z"/>
                    </svg>
                  </button>
                  <div class="flex-1 bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                    <div class="bg-yellow-400 h-2 rounded-full" style="width: <?php echo e($percent); ?>%;"></div>
                  </div>
                  <span class="text-sm text-gray-500 w-8 text-right"><?php echo e($count); ?></span>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="text-right mt-3">
              <button type="button" class="text-xs text-blue-600 hover:underline"
                      @click="filter = 0" x-show="filter !== 0">
                Clear Filter
              </button>
            </div>

            
            <div class="space-y-4 mt-6">
              <?php $__currentLoopData = $product->reviews()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <template x-if="filter === 0 || filter === <?php echo e($review->rating); ?>">
                  <div class="border-b border-gray-200 dark:border-gray-700 pb-3 flex items-start gap-3">
                    
                    <?php
                      $user = $review->customer?->user;
                      $avatar = $user?->profile_image
                        ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->customer->name ?? 'User') . '&background=random';
                    ?>
                    <img src="<?php echo e($avatar); ?>" alt="Avatar"
                         class="w-10 h-10 rounded-full object-cover border dark:border-gray-700">

                    
                    <div class="flex-1">
                      <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                          <p class="font-semibold text-gray-800 dark:text-white">
                            <?php echo e($review->customer->name ?? 'Anonymous'); ?>

                          </p>
                          <div class="flex">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                              <svg xmlns="http://www.w3.org/2000/svg"
                                   fill="<?php echo e($i <= $review->rating ? 'currentColor' : 'none'); ?>"
                                   class="w-4 h-4 <?php echo e($i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'); ?>"
                                   viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 
                                         0l1.286 3.948a1 1 0 00.95.69h4.148c.969 
                                         0 1.371 1.24.588 1.81l-3.36 
                                         2.44a1 1 0 00-.364 1.118l1.286 
                                         3.948c.3.921-.755 1.688-1.54 
                                         1.118l-3.36-2.44a1 1 0 00-1.176 
                                         0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                                         1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                                         1 0 00.95-.69l1.286-3.948z"/>
                              </svg>
                            <?php endfor; ?>
                          </div>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                          <?php echo e(optional($review->created_at)->diffForHumans() ?? '—'); ?>

                        </span>
                      </div>
                      <p class="text-sm text-gray-700 dark:text-gray-300 mt-2"><?php echo e($review->comment); ?></p>

                      
                      <?php if(auth()->check() && $review->customer_id === auth()->user()->customer?->id): ?>
                        <form action="<?php echo e(route('shop.reviews.destroy', $review)); ?>" method="POST" class="mt-2">
                          <?php echo csrf_field(); ?>
                          <?php echo method_field('DELETE'); ?>
                          <button class="text-xs text-red-600 hover:underline">Delete</button>
                        </form>
                      <?php endif; ?>
                    </div>
                  </div>
                </template>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/products/show.blade.php ENDPATH**/ ?>