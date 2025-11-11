<tr>
  <td class="px-5 py-3">
    <span class="font-semibold text-gray-800 dark:text-white">{{ $category->name }}</span>
  </td>

  <td class="px-5 py-3 text-gray-700 dark:text-gray-300">
    {{ $category->parent?->name ?? '-' }}
  </td>

  <td class="px-5 py-3 text-gray-700 dark:text-gray-300">
    {{ count($category->products) }} {{ Str::plural('product', count($category->products)) }}
  </td>

  <td class="px-5 py-3 text-right">
    <a href="{{ route('categories.edit', $category) }}" 
       class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium transition">
      Edit
    </a>
    <button 
      @click.prevent="
        title = '{{ $category->name }}'; 
        deleteUrl = '{{ route('categories.destroy', $category) }}'; 
        isModalOpen = true
      "
      class="text-red-600 hover:text-red-700 dark:hover:text-red-400 ml-3 font-medium transition"
    >
      Delete
    </button>
  </td>
</tr>