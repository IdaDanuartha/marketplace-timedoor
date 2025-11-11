@foreach ($categories as $category)
  <option value="{{ $category->id }}" 
    {{ old('category_id') == $category->id ? 'selected' : '' }}>
    {{ str_repeat('— ', $depth) . $category->name }}
  </option>

  @if ($category->children->isNotEmpty())
    @include('admin.products.partials.category-options', [
      'categories' => $category->children,
      'depth' => $depth + 1
    ])
  @endif
@endforeach