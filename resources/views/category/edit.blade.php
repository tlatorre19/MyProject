@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Header --}}
        <div class="pt-2 pb-4">
            <h3 class="fw-bold mb-1">Edit Category</h3>
            <h6 class="text-muted">Update an existing category for lost and found items</h6>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-round" style="border:none; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

                    {{-- Card Header --}}
                    <div class="card-header border-0 pb-0 pt-4 px-4"
                         style="background:white; border-radius:16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:46px; height:46px; border-radius:12px;
                                        background:linear-gradient(135deg,#2d6a4f,#40916c);
                                        display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-folder-open" style="color:white; font-size:18px;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0" style="color:#1b4332;">Edit Category</h5>
                                <small class="text-muted">SNSU Lost & Found System</small>
                            </div>
                        </div>
                        <hr class="mt-3 mb-0">
                    </div>

                    <div class="card-body px-4 pt-3 pb-4">
                        <form action="{{ route('category.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Category Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-tag me-1 text-success"></i> Category
                                </label>
                                <select name="name"
                                    class="form-select @error('name') is-invalid @enderror"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">
                                    <option value="">Select Category</option>

                                    <optgroup label="Electronics">
                                        <option value="Phones" {{ $category->name == 'Phones' ? 'selected' : '' }}>Phones</option>
                                        <option value="Laptops" {{ $category->name == 'Laptops' ? 'selected' : '' }}>Laptops</option>
                                        <option value="Tablets" {{ $category->name == 'Tablets' ? 'selected' : '' }}>Tablets</option>
                                        <option value="Earphones" {{ $category->name == 'Earphones' ? 'selected' : '' }}>Earphones</option>
                                        <option value="Chargers" {{ $category->name == 'Chargers' ? 'selected' : '' }}>Chargers</option>
                                    </optgroup>

                                    <optgroup label="Clothing & Accessories">
                                        <option value="Shirts" {{ $category->name == 'Shirts' ? 'selected' : '' }}>Shirts</option>
                                        <option value="Pants" {{ $category->name == 'Pants' ? 'selected' : '' }}>Pants</option>
                                        <option value="Jackets" {{ $category->name == 'Jackets' ? 'selected' : '' }}>Jackets</option>
                                        <option value="Hats" {{ $category->name == 'Hats' ? 'selected' : '' }}>Hats</option>
                                        <option value="Bags" {{ $category->name == 'Bags' ? 'selected' : '' }}>Bags</option>
                                    </optgroup>

                                    <optgroup label="Documents">
                                        <option value="ID Cards" {{ $category->name == 'ID Cards' ? 'selected' : '' }}>ID Cards</option>
                                        <option value="Passports" {{ $category->name == 'Passports' ? 'selected' : '' }}>Passports</option>
                                        <option value="Licenses" {{ $category->name == 'Licenses' ? 'selected' : '' }}>Licenses</option>
                                        <option value="Cards" {{ $category->name == 'Cards' ? 'selected' : '' }}>Cards</option>
                                    </optgroup>

                                    <optgroup label="Jewelry & Valuables">
                                        <option value="Rings" {{ $category->name == 'Rings' ? 'selected' : '' }}>Rings</option>
                                        <option value="Necklaces" {{ $category->name == 'Necklaces' ? 'selected' : '' }}>Necklaces</option>
                                        <option value="Watches" {{ $category->name == 'Watches' ? 'selected' : '' }}>Watches</option>
                                        <option value="Bracelets" {{ $category->name == 'Bracelets' ? 'selected' : '' }}>Bracelets</option>
                                    </optgroup>

                                    <optgroup label="School Supplies">
                                        <option value="Books" {{ $category->name == 'Books' ? 'selected' : '' }}>Books</option>
                                        <option value="Notebooks" {{ $category->name == 'Notebooks' ? 'selected' : '' }}>Notebooks</option>
                                        <option value="Pens" {{ $category->name == 'Pens' ? 'selected' : '' }}>Pens</option>
                                        <option value="Calculators" {{ $category->name == 'Calculators' ? 'selected' : '' }}>Calculators</option>
                                    </optgroup>

                                    <optgroup label="Keys">
                                        <option value="House Keys" {{ $category->name == 'House Keys' ? 'selected' : '' }}>House Keys</option>
                                        <option value="Car Keys" {{ $category->name == 'Car Keys' ? 'selected' : '' }}>Car Keys</option>
                                        <option value="Padlocks" {{ $category->name == 'Padlocks' ? 'selected' : '' }}>Padlocks</option>
                                    </optgroup>

                                    <optgroup label="Wallets & Purses">
                                        <option value="Wallets" {{ $category->name == 'Wallets' ? 'selected' : '' }}>Wallets</option>
                                        <option value="Purses" {{ $category->name == 'Purses' ? 'selected' : '' }}>Purses</option>
                                        <option value="Coin Purses" {{ $category->name == 'Coin Purses' ? 'selected' : '' }}>Coin Purses</option>
                                    </optgroup>

                                    <optgroup label="Sports Equipment">
                                        <option value="Balls" {{ $category->name == 'Balls' ? 'selected' : '' }}>Balls</option>
                                        <option value="Rackets" {{ $category->name == 'Rackets' ? 'selected' : '' }}>Rackets</option>
                                        <option value="Helmets" {{ $category->name == 'Helmets' ? 'selected' : '' }}>Helmets</option>
                                        <option value="Gloves" {{ $category->name == 'Gloves' ? 'selected' : '' }}>Gloves</option>
                                    </optgroup>

                                    <optgroup label="Others">
                                        <option value="Others" {{ $category->name == 'Others' ? 'selected' : '' }}>Others</option>
                                    </optgroup>
                                </select>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-align-left me-1 text-success"></i> Description
                                </label>
                                <textarea name="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Describe this category..."
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">{{ $category->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn fw-bold px-4"
                                        style="background:linear-gradient(135deg,#2d6a4f,#40916c);
                                               color:white; border-radius:10px; padding:10px 28px;">
                                    <i class="fas fa-save me-2"></i> Update Category
                                </button>
                                <a href="{{ route('category.index') }}" class="btn fw-bold px-4"
                                   style="border:1.5px solid #ccc; border-radius:10px;
                                          padding:10px 28px; color:#666;">
                                    Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection