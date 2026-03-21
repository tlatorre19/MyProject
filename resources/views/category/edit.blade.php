@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Category</h2>

    <div class="card">
        <div class="card-header bg-primary text-white">
            Edit Category
        </div>
        <div class="card-body">
            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Category Name</label>
                    <select name="name" class="form-select" required>
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
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ $category->description }}</textarea>
                </div>

                <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection