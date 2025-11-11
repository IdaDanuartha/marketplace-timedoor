<div
  x-show="isModalOpen"
  x-cloak
  class="fixed inset-0 flex items-center justify-center p-5 z-99999"
>
  <!-- Backdrop -->
  <div @click="isModalOpen = false" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

  <!-- Modal -->
  <div
    @click.outside="isModalOpen = false"
    class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-lg p-6"
  >
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Delete <span x-text="title" class="capitalize"></span></h2>
      <button 
        @click="isModalOpen = false"
        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
      >
        ✕
      </button>
    </div>

    <!-- Body -->
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
      Are you sure you want to delete 
      <b class="text-gray-800 dark:text-gray-200 lowercase" x-text="title"></b>?<br>
      This action cannot be undone.
    </p>

    <!-- Actions -->
    <div class="flex justify-end gap-3">
      <button 
        @click="isModalOpen = false"
        class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 transition"
      >
        Cancel
      </button>

      <form :action="deleteUrl" method="POST">
        @csrf
        @method('DELETE')
        <button 
          type="submit"
          class="px-4 py-2 bg-red-600 hover:bg-red-700 text-sm rounded-lg text-white transition"
        >
          Delete
        </button>
      </form>
    </div>
  </div>
</div>