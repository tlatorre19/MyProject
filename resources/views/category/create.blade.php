@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Category</h2>

    <div class="card">
        <div class="card-header bg-primary text-white">
            New Category
        </div>
        <div class="card-body">
            <form action="{{ route('category.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Category</label>
                    <select name="name" class="form-select @error('name') is-invalid @enderror">
                        <option value="">Select Category</option>

                        <optgroup label="Electronics">
                            <option value="Phones" {{ old('name') == 'Phones' ? 'selected' : '' }}>Phones</option>
                            <option value="Laptops" {{ old('name') == 'Laptops' ? 'selected' : '' }}>Laptops</option>
                            <option value="Tablets" {{ old('name') == 'Tablets' ? 'selected' : '' }}>Tablets</option>
                            <option value="Earphones" {{ old('name') == 'Earphones' ? 'selected' : '' }}>Earphones</option>
                            <option value="Chargers" {{ old('name') == 'Chargers' ? 'selected' : '' }}>Chargers</option>
                        </optgroup>

                        <optgroup label="Clothing & Accessories">
                            <option value="Shirts" {{ old('name') == 'Shirts' ? 'selected' : '' }}>Shirts</option>
                            <option value="Pants" {{ old('name') == 'Pants' ? 'selected' : '' }}>Pants</option>
                            <option value="Jackets" {{ old('name') == 'Jackets' ? 'selected' : '' }}>Jackets</option>
                            <option value="Hats" {{ old('name') == 'Hats' ? 'selected' : '' }}>Hats</option>
                            <option value="Bags" {{ old('name') == 'Bags' ? 'selected' : '' }}>Bags</option>
                        </optgroup>

                        <optgroup label="Documents">
                            <option value="ID Cards" {{ old('name') == 'ID Cards' ? 'selected' : '' }}>ID Cards</option>
                            <option value="Passports" {{ old('name') == 'Passports' ? 'selected' : '' }}>Passports</option>
                            <option value="Licenses" {{ old('name') == 'Licenses' ? 'selected' : '' }}>Licenses</option>
                            <option value="Cards" {{ old('name') == 'Cards' ? 'selected' : '' }}>Cards</option>
                        </optgroup>

                        <optgroup label="Jewelry & Valuables">
                            <option value="Rings" {{ old('name') == 'Rings' ? 'selected' : '' }}>Rings</option>
                            <option value="Necklaces" {{ old('name') == 'Necklaces' ? 'selected' : '' }}>Necklaces</option>
                            <option value="Watches" {{ old('name') == 'Watches' ? 'selected' : '' }}>Watches</option>
                            <option value="Bracelets" {{ old('name') == 'Bracelets' ? 'selected' : '' }}>Bracelets</option>
                        </optgroup>

                        <optgroup label="School Supplies">
                            <option value="Books" {{ old('name') == 'Books' ? 'selected' : '' }}>Books</option>
                            <option value="Notebooks" {{ old('name') == 'Notebooks' ? 'selected' : '' }}>Notebooks</option>
                            <option value="Pens" {{ old('name') == 'Pens' ? 'selected' : '' }}>Pens</option>
                            <option value="Calculators" {{ old('name') == 'Calculators' ? 'selected' : '' }}>Calculators</option>
                        </optgroup>

                        <optgroup label="Keys">
                            <option value="House Keys" {{ old('name') == 'House Keys' ? 'selected' : '' }}>House Keys</option>
                            <option value="Car Keys" {{ old('name') == 'Car Keys' ? 'selected' : '' }}>Car Keys</option>
                            <option value="Padlocks" {{ old('name') == 'Padlocks' ? 'selected' : '' }}>Padlocks</option>
                        </optgroup>

                        <optgroup label="Wallets & Purses">
                            <option value="Wallets" {{ old('name') == 'Wallets' ? 'selected' : '' }}>Wallets</option>
                            <option value="Purses" {{ old('name') == 'Purses' ? 'selected' : '' }}>Purses</option>
                            <option value="Coin Purses" {{ old('name') == 'Coin Purses' ? 'selected' : '' }}>Coin Purses</option>
                        </optgroup>

                        <optgroup label="Sports Equipment">
                            <option value="Balls" {{ old('name') == 'Balls' ? 'selected' : '' }}>Balls</option>
                            <option value="Rackets" {{ old('name') == 'Rackets' ? 'selected' : '' }}>Rackets</option>
                            <option value="Helmets" {{ old('name') == 'Helmets' ? 'selected' : '' }}>Helmets</option>
                            <option value="Gloves" {{ old('name') == 'Gloves' ? 'selected' : '' }}>Gloves</option>
                        </optgroup>

                        <optgroup label="Others">
                            <option value="Others" {{ old('name') == 'Others' ? 'selected' : '' }}>Others</option>
                        </optgroup>
                    </select>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection