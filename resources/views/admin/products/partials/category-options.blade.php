@foreach ($categories as $category)
  @php
    $isSelected = old('category_id', $selectedCategory ?? null) == $category->id;
  @endphp
  <option value="{{ $category->id }}" {{ $isSelected ? 'selected' : '' }}>
    {{ str_repeat('— ', $depth) . $category->name }}
  </option>

  @if ($category->children && $category->children->isNotEmpty())
    @include('admin.products.partials.category-options', [
      'categories' => $category->children,
      'depth' => $depth + 1,
      'selectedCategory' => $selectedCategory ?? null,
    ])
  @endif
@endforeach